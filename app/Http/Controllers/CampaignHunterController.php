<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Weapon;
use DB;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use App\Models\Armor;
use Inertia\Response;
use App\Enum\ItemType;
use App\Models\Hunter;
use App\Models\Campaign;
use App\Models\WeaponType;
use Illuminate\Support\Collection;
use App\Http\Requests\HunterRequest;
use Illuminate\Http\RedirectResponse;
use Mockery\Exception;

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

    public function show(Campaign $campaign, Hunter $hunter, string $tab = 'items', WeaponType $weaponType = null): Response
    {
        $user = $hunter->getUser();
        $canEdit = auth()->user()?->can('update', [$campaign, $hunter]);
        $hunter->load('palico', 'items', 'weapons', 'armors', 'otherItems', 'monsterItems');
        $commonItems = Item::where('type', ItemType::COMMON->name)->get();
        $otherItems = Item::where('type', ItemType::OTHER->name)->get();
        $monsterItems = Item::where('type', ItemType::MONSTER_PART->name)->get();

        $tabOpened = $tab;

        $weaponTypes = WeaponType::all();
        $weapons = [];
        if ($weaponType) {
            $weapons = create_weapon_tree($weaponType);
        }

        $armors = Armor::with('skills', 'items')->get()->groupBy(fn (Armor $armor) => strtolower($armor->type->label('en')))->map(fn (Collection $armors) => $armors->groupBy(fn (Armor $armor) => $armor->rarity));

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

    public function craftWeapon(Campaign $campaign, Hunter $hunter, WeaponType $weaponType, Weapon $weapon): JsonResponse|RedirectResponse
    {
        if (!$hunter->canCraftWeapon($weapon)) {
            return response()->json([
                'error' => __('The weapon cannot be crafted.'),
            ], 400);
        }

        DB::transaction(function () use ($hunter, $weapon) {
            $weapon->items->each(function (Item $item) use ($hunter) {
                $hunterItem = $hunter->items()->findOrFail($item->id);
                $hunterItem->pivot->decrement('number', $item->pivot->number);
            });

            if ($weapon->parent_id) {
                $hunter->weapons()->detach($weapon->parent_id);
            }

            $hunter->weapons()->attach($weapon);
        });

        return back(303);
    }

    public function craftArmor(Campaign $campaign, Hunter $hunter, Armor $armor): JsonResponse|RedirectResponse
    {
        if (!$hunter->canCraftArmor($armor)) {
            return response()->json([
                'error' => __('The armor cannot be crafted.'),
            ], 400);
        }

        DB::transaction(function () use ($hunter, $armor) {
            $armor->items->each(function (Item $item) use ($hunter) {
                $hunterItem = $hunter->items()->findOrFail($item->id);
                $hunterItem->pivot->decrement('number', $item->pivot->number);
            });

            $hunter->armors()->attach($armor);
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
