<?php

namespace App\Http\Controllers;

use DB;
use Event;
use App\Models\Day;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterExpansion;
use App\Models\DowntimeActivity;
use App\Events\UserMonsterHunted;
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

        return Inertia::render('Campaign/Create', [
            'teams' => $teams,
            ...$this->campaignRuleOptions(),
        ]);
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
            // The members list names what each hunter is carrying and who their
            // palico is, so both come with the membership.
            'users.membership.hunter.weaponType',
            'users.membership.hunter.palico'
        );
        $campaign->loadCount('days');

        $downtimeDays = DowntimeActivity::all();
        $monsters = Monster::all();

        return Inertia::render('Campaign/Show', [
            'campaign' => $campaign,
            'downtimeDays' => $downtimeDays,
            'monsters' => $monsters,
            // The cap on a hunter's downtime day, sent so the two modals that
            // build one do not write the number out themselves.
            'maxDowntimeActivities' => Campaign::MAX_DOWNTIME_ACTIVITIES,
            'availableRoles' => collect(config('permission.campaign-roles'))
                ->map(fn (array $role): array => [
                    ...$role,
                    'name' => __($role['name']),
                    'description' => __($role['description']),
                ])
                ->values(),
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

        return Inertia::render('Campaign/Edit', [
            'campaign' => $campaign,
            ...$this->campaignRuleOptions(),
        ]);
    }

    /**
     * What both campaign forms need to show the rules and work the timer out.
     *
     * Only the names and the day counts travel. The rule text itself is in
     * `resources/lang/{en,es}/campaign-rules.php`, keyed by the case name sent
     * here as `key`, and the form reads it straight from vue-i18n.
     *
     * @return array{expansions: array<int, array{key: string, label: string, base_game: bool, extra_days: int}>, baseMaxDays: int, defaultExpansions: array<int, string>}
     */
    private function campaignRuleOptions(): array
    {
        return [
            'expansions' => MonsterExpansion::asCampaignOptions(),
            'baseMaxDays' => Campaign::BASE_MAX_DAYS,
            // What the create form starts out with ticked. Sent rather than
            // written into the form, so the default and the enum cannot drift.
            // The edit form ignores it and reads the campaign's own set.
            'defaultExpansions' => [MonsterExpansion::defaultCampaignBox()->name],
        ];
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
        DB::transaction(function () use ($campaign, $request): void {
            if ($request->get('type_day') === 'MONSTER') {
                $day = $campaign->days()->create([
                    'number' => $campaign->days()->count() + 1,
                    'monster_id' => $request->get('monster_id'),
                    'difficulty' => $request->get('difficulty'),
                    'hunted' => $request->boolean('hunted'),
                ]);

                if ($request->boolean('hunted')) {
                    Event::dispatch(new UserMonsterHunted($campaign, $day));
                }
            }

            if ($request->get('type_day') === 'DOWNTIME') {
                $day = $campaign->days()->create([
                    'number' => $campaign->days()->count() + 1,
                ]);

                $this->fillDowntimeDay($campaign, $day, $request);
            }
        });

        return back(303);
    }

    public function updateDay(AddOrUpdateCampaignDayRequest $request, Campaign $campaign, Day $day): RedirectResponse
    {
        DB::transaction(function () use ($campaign, $day, $request): void {
            if ($request->get('type_day') === 'MONSTER') {
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

            if ($request->get('type_day') === 'DOWNTIME') {
                // Cleared and written again rather than reconciled in place. A
                // hunter now holds a row per activity instead of exactly one,
                // so `updateExistingPivot` has no single row to address, and
                // the version that reconciled by hand attached new hunters
                // with the whole party's activity instead of their own.
                $day->hunters()->detach();

                $this->fillDowntimeDay($campaign, $day, $request);
            }
        });

        return back(303);
    }

    /**
     * Write a downtime day's activities, one pivot row per hunter per activity.
     *
     * A hunter holds up to `Campaign::MAX_DOWNTIME_ACTIVITIES` different ones.
     * The request has already capped the count, refused a repeat, and widened
     * the old scalar shape into a list, so there is one loop here rather than
     * a branch.
     */
    private function fillDowntimeDay(Campaign $campaign, Day $day, AddOrUpdateCampaignDayRequest $request): void
    {
        $sameForEveryone = $request->boolean('all_hunters_same_activity');

        $shared = (array) $request->input('day_id', []);

        $day->update([
            // The column holds the whole party's activity and can only hold
            // one, so it is filled when everybody spent the day on a single
            // activity and left null the moment there is a set to record. The
            // pivot rows are the complete answer either way.
            'downtime_activity_id' => $sameForEveryone && count($shared) === 1 ? $shared[0] : null,
            'all_hunters_same_activity' => $sameForEveryone,
            // A day that used to be a hunt keeps nothing of it. `updateDay`
            // relies on this rather than clearing the three itself, so the
            // day is written once either way.
            'monster_id' => null,
            'difficulty' => null,
            'hunted' => false,
        ]);

        $byHunter = $sameForEveryone
            ? $campaign->users
                ->pluck('membership.hunter_id')
                ->filter()
                ->mapWithKeys(fn (int $hunterId): array => [$hunterId => $shared])
                ->all()
            : (array) $request->input('hunter_day_id', []);

        foreach ($byHunter as $hunterId => $activities) {
            foreach ((array) $activities as $activityId) {
                $day->hunters()->attach($hunterId, ['downtime_activity_id' => $activityId]);
            }
        }
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $campaign->purge();

        return redirect()->route('dashboard');
    }
}
