<?php

namespace App\Http\Controllers;

use DB;
use Event;
use App\Models\Item;
use Inertia\Inertia;
use App\Models\Armor;
use Inertia\Response;
use App\Enum\ItemType;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\Campaign;
use App\Models\WeaponType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Requests\EquipRequest;
use App\Events\UserEquipmentCrafted;
use App\Http\Requests\HunterRequest;
use Illuminate\Http\RedirectResponse;

class CampaignHunterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(['campaign', Hunter::class], ['campaign', 'hunter']);
    }

    public function index(Campaign $campaign): RedirectResponse
    {
        return redirect()->route('campaigns.show', $campaign);
    }

    public function create(Campaign $campaign): Response
    {
        return Inertia::render('Hunter/Create', compact('campaign'));
    }

    public function store(HunterRequest $request, Campaign $campaign): RedirectResponse
    {
        $hunter = $campaign->hunters()->create($request->validated());
        $campaign->users()->updateExistingPivot(auth()->id(), ['hunter_id' => $hunter->id]);

        return redirect()->route('campaigns.hunters.edit', [$campaign, $hunter]);
    }

    public function show(Campaign $campaign, Hunter $hunter, string $tab = 'items', ?WeaponType $weaponType = null): Response
    {
        $user = $hunter->getUser();
        $canEdit = auth()->user()?->can('update', [$campaign, $hunter]);
        $hunter->load(
            'palico',
            'weaponType',
            'items',
            'weapons',
            'equippedWeapons',
            'armors',
            'equippedArmors',
            'otherItems',
            'monsterItems'
        );
        $commonItems = Item::where('type', ItemType::COMMON->name)->get();
        $otherItems = Item::where('type', ItemType::OTHER->name)->get();
        // Grouped by the monster they come from, so the picker can put a heading
        // over each set. A part dropped by more than one monster is listed under
        // each, and the handful that belong to none go last under their own.
        $monsterItems = Item::with('monsters')
            ->where('type', ItemType::MONSTER_PART->name)
            ->get()
            ->flatMap(fn (Item $item) => $item->monsters->isEmpty()
                ? [['monster' => __('Other'), 'item' => $item]]
                : $item->monsters->map(fn (Monster $monster) => ['monster' => $monster->name, 'item' => $item]))
            ->groupBy('monster')
            ->map(fn (Collection $entries, string $monster): array => [
                'monster' => $monster,
                'items' => $entries->pluck('item')->values(),
            ])
            ->sortBy(fn (array $group): string => $group['monster'] === __('Other') ? 'zzz' : $group['monster'])
            ->values();

        $tabOpened = $tab;

        $weaponTypes = WeaponType::with('weapons')->get();
        $weapons = [];
        if ($weaponType) {
            $weapons = create_weapon_tree($weaponType, $hunter);
        }

        $armors = Armor::with('skills', 'items')
            ->get()
            ->map(function (Armor $armor) use ($hunter) {
                $armor->equipped = $hunter->equippedArmors->firstWhere('id', $armor->id);
                $armor->can_craft = $hunter->canCraftArmor($armor);

                return $armor;
            })
            // The tab lines the three slots up in a row per monster, so a branch
            // holds one piece for each slot rather than a list by rarity: the data
            // is exactly seventeen branches of three.
            ->groupBy('branch')
            ->map(fn (Collection $pieces) => $pieces->keyBy('type_value'));

        return Inertia::render('Hunter/Show', compact(
            'campaign',
            'hunter',
            'tabOpened',
            'weaponType',
            'weapons',
            'armors',
            'user',
            'commonItems',
            'otherItems',
            'monsterItems',
            'weaponTypes',
            'canEdit'
        ));
    }

    public function showWeaponType(Campaign $campaign, Hunter $hunter, WeaponType $weaponType): Response
    {
        return $this->show($campaign, $hunter, 'weapons', $weaponType);
    }

    public function craftWeapon(Request $request, Campaign $campaign, Hunter $hunter, WeaponType $weaponType, Weapon $weapon): JsonResponse|RedirectResponse
    {
        $affordable = $hunter->craftableRecipes($weapon);

        if ($affordable->isEmpty()) {
            return response()->json([
                'error' => __('The weapon cannot be crafted.'),
            ], 400);
        }

        // A weapon buildable from two monsters lets the hunter say which parts to
        // spend. Without a choice the only recipe is the one they can afford, and
        // a choice they cannot afford is refused rather than quietly swapped.
        $recipe = $request->filled('recipe')
            ? $affordable->firstWhere('id', (int) $request->input('recipe'))
            : $affordable->first();

        if (! $recipe) {
            return response()->json([
                'error' => __('The weapon cannot be crafted with those materials.'),
            ], 400);
        }

        DB::transaction(function () use ($hunter, $weapon, $recipe): void {
            $recipe->items->each(function (Item $item) use ($hunter): void {
                $hunterItem = $hunter->items()->findOrFail($item->id);
                $hunterItem->pivot->decrement('number', $item->pivot->number);
            });

            if ($weapon->parent_id) {
                $hunter->weapons()->detach($weapon->parent_id);
            }

            $hunter->weapons()->attach($weapon);

            Event::dispatch(new UserEquipmentCrafted($hunter->getUser(), $weapon));
        });

        return back(303);
    }

    public function updateEquippedWeapon(EquipRequest $request, Campaign $campaign, Hunter $hunter, WeaponType $weaponType, Weapon $weapon): JsonResponse|RedirectResponse
    {
        // A hunter owns their starting weapon from the first day, but nothing ever
        // wrote it to the pivot, so equipping it was refused and there was no way
        // back to it once anything else of that type had been equipped.
        // Taking off the starting weapon would leave the hunter with nothing of
        // that type in hand, so it is the one weapon that only ever goes on.
        // Equipping anything else is how it leaves the hand.
        if ($weapon->is_default && ! $request->boolean('equip')) {
            return response()->json([
                'error' => __('The starting weapon cannot be unequipped.'),
            ], 400);
        }

        if (! $weapon->is_default && ! $hunter->weapons()->find($weapon->id)) {
            return response()->json([
                'error' => __('The weapon cannot be equipped.'),
            ], 400);
        }

        DB::transaction(function () use ($weapon, $request, $hunter): void {
            if ($weapon->is_default && ! $hunter->weapons()->find($weapon->id)) {
                $hunter->weapons()->attach($weapon);
            }

            if ($request->boolean('equip')) {
                $hunter->weapons()->where('type_id', $weapon->type_id)->each(function (Weapon $hunterWeapon): void {
                    $hunterWeapon->pivot->equipped = false;
                    $hunterWeapon->pivot->save();
                });
            }

            $hunter->weapons()->updateExistingPivot($weapon->id, [
                'equipped' => $request->boolean('equip'),
            ]);
        });

        return back(303);
    }

    /**
     * A hunter carries one weapon type into a hunt, and never none: picking a
     * second replaces the first, and picking the one already carried changes
     * nothing.
     */
    public function updateHuntingWeaponType(Campaign $campaign, Hunter $hunter, WeaponType $weaponType): RedirectResponse
    {
        $this->authorize('update', [$campaign, $hunter]);

        $hunter->update(['weapon_type_id' => $weaponType->id]);

        return back(303);
    }

    public function craftArmor(Campaign $campaign, Hunter $hunter, Armor $armor): JsonResponse|RedirectResponse
    {
        if (! $hunter->canCraftArmor($armor)) {
            return response()->json([
                'error' => __('The armor cannot be crafted.'),
            ], 400);
        }

        DB::transaction(function () use ($hunter, $armor): void {
            $armor->items->each(function (Item $item) use ($hunter): void {
                $hunterItem = $hunter->items()->findOrFail($item->id);
                $hunterItem->pivot->decrement('number', $item->pivot->number);
            });

            $hunter->armors()->attach($armor);

            Event::dispatch(new UserEquipmentCrafted($hunter->getUser(), $armor));
        });

        return back(303);
    }

    public function updateEquippedArmor(EquipRequest $request, Campaign $campaign, Hunter $hunter, Armor $armor): JsonResponse|RedirectResponse
    {
        if (! $hunter->armors()->find($armor->id)) {
            return response()->json([
                'error' => __('The armor cannot be equipped.'),
            ], 400);
        }

        DB::transaction(function () use ($armor, $request, $hunter): void {
            if ($request->boolean('equip')) {
                $hunter->armors()->where('type', $armor->type->name)->each(function (Armor $hunterArmor): void {
                    $hunterArmor->pivot->equipped = false;
                    $hunterArmor->pivot->save();
                });
            }

            $hunter->armors()->updateExistingPivot($armor->id, [
                'equipped' => $request->boolean('equip'),
            ]);
        });

        return back(303);
    }

    public function edit(Campaign $campaign, Hunter $hunter): Response
    {
        return Inertia::render('Hunter/Edit', compact('campaign', 'hunter'));
    }

    public function update(HunterRequest $request, Campaign $campaign, Hunter $hunter): RedirectResponse
    {
        $hunter->update($request->validated());

        return back(303);
    }

    public function destroy(Campaign $campaign, Hunter $hunter): RedirectResponse
    {
        $hunter->delete();

        return redirect()->route('campaigns.show', $campaign);
    }
}
