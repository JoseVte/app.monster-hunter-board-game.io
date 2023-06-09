<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CreateCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Requests\UpdateCampaignPotionsRequest;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Campaign::class, 'campaign');
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    public function create(): Response
    {
        $teams = auth()->user()->allTeams()->pluck('name', 'id')->toArray();

        return Inertia::render('Campaign/Create', compact('teams'));
    }

    public function store(CreateCampaignRequest $request): RedirectResponse
    {
        $campaign = Campaign::create($request->validated());
        $campaign->users()->attach(auth()->id(), [
            'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
        ]);

        return redirect()->route('campaigns.edit', ['campaign' => $campaign]);
    }

    public function show(Campaign $campaign): RedirectResponse|Response
    {
        if ($campaign->team_id !== auth()->user()->current_team_id) {
            auth()->user()?->switchTeam($campaign->team);

            return redirect()->route('campaigns.show', $campaign);
        }

        $campaign->load(
            'team', 'team.owner', 'team.users', 'team.teamInvitations',
            'campaignInvitations', 'campaignInvitations.role',
            'users', 'users.membership.role'
        );
        $campaign->loadCount('days');

        return Inertia::render('Campaign/Show', [
            'campaign' => $campaign,
            'availableRoles' => array_values(config('permission.campaign-roles')),
            'permissions' => [
                'canAddCampaignMembers' => Gate::check('addCampaignMember', $campaign),
                'canDeleteCampaign' => Gate::check('delete', $campaign),
                'canRemoveCampaignMembers' => Gate::check('removeCampaignMember', $campaign),
                'canUpdateCampaign' => Gate::check('update', $campaign),
                'canUpdateCampaignMembers' => Gate::check('updateCampaignMember', $campaign),
            ],
        ]);
    }

    public function edit(Campaign $campaign): Response
    {
        $campaign->load('team', 'team.owner');

        return Inertia::render('Campaign/Edit', compact('campaign'));
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $campaign->update($request->validated());

        return back(303);
    }

    public function updatePotions(UpdateCampaignPotionsRequest $request, Campaign $campaign): RedirectResponse
    {
        $campaign->update($request->validated());

        return back(303);
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $campaign->delete();

        return redirect()->route('dashboard');
    }
}
