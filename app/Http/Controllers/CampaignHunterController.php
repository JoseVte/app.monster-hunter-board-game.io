<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Inertia\Inertia;
use Inertia\Response;
use App\Enum\ItemType;
use App\Models\Hunter;
use App\Models\Campaign;
use App\Http\Requests\HunterRequest;
use Illuminate\Http\RedirectResponse;

class CampaignHunterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource([Hunter::class, 'campaign'], ['campaign', 'hunter']);
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

    public function show(Campaign $campaign, Hunter $hunter): Response
    {
        $user = $hunter->getUser();
        $hunter->load('palico', 'items');
        $commonItems = Item::where('type', ItemType::COMMON->name)->get();

        return Inertia::render('Hunter/Show', compact('campaign', 'hunter', 'user', 'commonItems'));
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