<?php

namespace App\Http\Controllers;

use App\Models\Item;
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

        $armors = Armor::with('skills')->get()->groupBy(fn (Armor $armor) => strtolower($armor->type->label('en')))->map(fn (Collection $armors) => $armors->groupBy(fn (Armor $armor) => $armor->rarity));

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
