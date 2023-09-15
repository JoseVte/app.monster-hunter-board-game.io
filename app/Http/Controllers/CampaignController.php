<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Day;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Hunter;
use App\Models\Monster;
use App\Models\Campaign;
use App\Models\DowntimeActivity;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CreateCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Requests\UpdateCampaignPotionsRequest;
use App\Http\Requests\AddOrUpdateCampaignDayRequest;

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
            'team',
            'team.owner',
            'team.users',
            'team.teamInvitations',
            'campaignInvitations',
            'campaignInvitations.role',
            'days',
            'days.monster',
            'days.downtimeActivity',
            'days.hunters',
            'days.hunters.pivot.downtimeActivity',
            'users',
            'users.membership.role',
            'users.membership.hunter'
        );
        $campaign->loadCount('days');

        $downtimeDays = DowntimeActivity::all();
        $monsters = Monster::all();

        return Inertia::render('Campaign/Show', [
            'campaign' => $campaign,
            'downtimeDays' => $downtimeDays,
            'monsters' => $monsters,
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

    public function addDay(AddOrUpdateCampaignDayRequest $request, Campaign $campaign): RedirectResponse
    {
        DB::transaction(static function () use ($campaign, $request): void {
            if ('MONSTER' === $request->get('type_day')) {
                $campaign->days()->create([
                    'number' => $campaign->days()->count() + 1,
                    'monster_id' => $request->get('monster_id'),
                    'difficulty' => $request->get('difficulty'),
                    'hunted' => $request->boolean('hunted'),
                ]);
            }

            if ('DOWNTIME' === $request->get('type_day')) {
                $day = $campaign->days()->create([
                    'number' => $campaign->days()->count() + 1,
                ]);
                if ($request->boolean('all_hunters_same_activity')) {
                    $day->update([
                        'downtime_activity_id' => $request->get('day_id'),
                        'all_hunters_same_activity' => true,
                    ]);
                    foreach ($campaign->users as $user) {
                        if ($user->membership->hunter_id) {
                            $day->hunters()->attach($user->membership->hunter_id, [
                                'downtime_activity_id' => $request->get('day_id'),
                            ]);
                        }
                    }
                } else {
                    foreach ($request->get('hunter_day_id') as $hunterId => $dayId) {
                        $day->hunters()->attach($hunterId, [
                            'downtime_activity_id' => $dayId,
                        ]);
                    }
                }
            }
        });

        return back(303);
    }

    public function updateDay(AddOrUpdateCampaignDayRequest $request, Campaign $campaign, Day $day): RedirectResponse
    {
        DB::transaction(static function () use ($campaign, $day, $request): void {
            if ('MONSTER' === $request->get('type_day')) {
                $day->update([
                    'downtime_activity_id' => null,
                    'all_hunters_same_activity' => false,
                    'monster_id' => $request->get('monster_id'),
                    'difficulty' => $request->get('difficulty'),
                    'hunted' => $request->boolean('hunted'),
                ]);

                // Remove all related
                $day->hunters()->detach();
            }

            if ('DOWNTIME' === $request->get('type_day')) {
                $day->update([
                    'downtime_activity_id' => $request->get('day_id'),
                    'all_hunters_same_activity' => $request->boolean('all_hunters_same_activity'),
                    'monster_id' => null,
                    'difficulty' => null,
                    'hunted' => false,
                ]);
                if ($request->boolean('all_hunters_same_activity')) {
                    foreach ($campaign->users as $user) {
                        if ($user->membership->hunter_id) {
                            if ($day->hunters()->find($user->membership->hunter_id)) {
                                $day->hunters()->updateExistingPivot($user->membership->hunter_id, [
                                    'downtime_activity_id' => $request->get('day_id'),
                                ]);
                            } else {
                                $day->hunters()->attach($user->membership->hunter_id, [
                                    'downtime_activity_id' => $request->get('day_id'),
                                ]);
                            }
                        }
                    }
                } else {
                    foreach ($request->get('hunter_day_id') as $hunterId => $dayId) {
                        if ($day->hunters()->find($hunterId)) {
                            $day->hunters()->updateExistingPivot($hunterId, [
                                'downtime_activity_id' => $dayId,
                            ]);
                        } else {
                            $day->hunters()->attach($hunterId, [
                                'downtime_activity_id' => $request->get('day_id'),
                            ]);
                        }
                    }
                }
            }
        });

        return back(303);
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        DB::transaction(static function () use ($campaign): void {
            $campaign->days()->delete();
            $campaign->users()->detach();
            Hunter::where('campaign_id', $campaign->id)->delete();
            $campaign->delete();
        });

        return redirect()->route('dashboard');
    }
}
