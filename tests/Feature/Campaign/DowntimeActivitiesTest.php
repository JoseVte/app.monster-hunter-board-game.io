<?php

use App\Models\User;
use App\Enum\DayType;
use App\Models\Hunter;
use App\Models\Campaign;
use App\Models\DowntimeActivity;

/**
 * A hunter spends a downtime day on up to three different activities.
 * Everything here is about that boundary: the cap, and the "different" in
 * "three different", which is the part Laravel's own `distinct` gets wrong.
 */
beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);

    $this->activities = DowntimeActivity::factory(5)->create();
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
});

function downtimeDay(Campaign $campaign, array $payload): Illuminate\Testing\TestResponse
{
    return test()->put(route('campaigns.add-day', $campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => false,
        ...$payload,
    ]);
}

test('a hunter can spend a downtime day on three different activities', function (): void {
    $chosen = $this->activities->take(3)->pluck('id')->all();

    $response = downtimeDay($this->campaign, ['hunter_day_id' => [$this->hunter->id => $chosen]]);

    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $day = $this->campaign->days()->sole();

    expect($day->hunters()->pluck('downtime_activity_id')->sort()->values()->all())
        ->toEqual(collect($chosen)->sort()->values()->all())
        // The column holds the party's single activity and there is a set here,
        // so the pivot rows are the only record of what was done.
        ->and($day->downtime_activity_id)->toBeNull();
});

test('a fourth activity is refused', function (): void {
    $response = downtimeDay($this->campaign, [
        'hunter_day_id' => [$this->hunter->id => $this->activities->take(4)->pluck('id')->all()],
    ]);

    $response->assertSessionHasErrors("hunter_day_id.{$this->hunter->id}", errorBag: 'addOrUpdateCampaignDay');
    expect($this->campaign->days()->count())->toEqual(0);
});

test('the same activity twice in one day is refused', function (): void {
    $activity = $this->activities->first()->id;

    $response = downtimeDay($this->campaign, [
        'hunter_day_id' => [$this->hunter->id => [$activity, $activity]],
    ]);

    $response->assertSessionHasErrors("hunter_day_id.{$this->hunter->id}", errorBag: 'addOrUpdateCampaignDay');
    expect($this->campaign->days()->count())->toEqual(0);
});

test('two hunters may spend the day on the same activity', function (): void {
    // The obvious way to write the rule above is Laravel's `distinct`, which
    // compares every entry against every other one across the whole array and
    // would refuse this, the common case.
    $other = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $activity = $this->activities->first()->id;

    $response = downtimeDay($this->campaign, [
        'hunter_day_id' => [
            $this->hunter->id => [$activity],
            $other->id => [$activity],
        ],
    ]);

    $response->assertSessionHasNoErrors();
    expect($this->campaign->days()->sole()->hunters()->count())->toEqual(2);
});

test('the same activity for everyone replicates the whole set', function (): void {
    $second = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->campaign->users()->updateExistingPivot($this->user->id, ['hunter_id' => $this->hunter->id]);

    // A second member, so the shortcut has more than one hunter to copy to.
    $other = User::factory()->withPersonalTeam()->create();
    $this->campaign->users()->attach($other, [
        'role_id' => Spatie\Permission\Models\Role::findByName('admin-campaign', 'sanctum')->id,
        'hunter_id' => $second->id,
    ]);

    $chosen = $this->activities->take(3)->pluck('id')->all();

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        'day_id' => $chosen,
    ]);

    $response->assertSessionHasNoErrors();

    $day = $this->campaign->days()->sole();

    expect($day->hunters()->count())->toEqual(6)
        ->and($day->all_hunters_same_activity)->toBeTrue()
        ->and($day->hunters()->wherePivot('hunter_id', $second->id)->pluck('downtime_activity_id')->sort()->values()->all())
        ->toEqual(collect($chosen)->sort()->values()->all());
});

test('one activity for everyone is still recorded on the day itself', function (): void {
    $this->campaign->users()->updateExistingPivot($this->user->id, ['hunter_id' => $this->hunter->id]);
    $activity = $this->activities->first()->id;

    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        // The old scalar shape, which the request widens into a list. Kept as a
        // scalar here on purpose: it is what every caller sent before this, and
        // what the column below exists for.
        'day_id' => $activity,
    ])->assertSessionHasNoErrors();

    expect($this->campaign->days()->sole())
        ->downtime_activity_id->toEqual($activity)
        ->all_hunters_same_activity->toBeTrue();
});

test('editing a downtime day replaces its activities rather than adding to them', function (): void {
    downtimeDay($this->campaign, [
        'hunter_day_id' => [$this->hunter->id => $this->activities->take(3)->pluck('id')->all()],
    ])->assertSessionHasNoErrors();

    $day = $this->campaign->days()->sole();
    $kept = $this->activities->last()->id;

    $this->put(route('campaigns.update-day', [$this->campaign, $day]), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => false,
        'hunter_day_id' => [$this->hunter->id => [$kept]],
    ])->assertSessionHasNoErrors();

    expect($day->hunters()->pluck('downtime_activity_id')->all())->toEqual([$kept]);
});

test('the cap is one number, shared by the request and the page that builds a day', function (): void {
    // It stopped being a per-campaign choice, so the only thing left to check
    // is that the form is handed the same figure the request asserts.
    $this->get(route('campaigns.show', $this->campaign))->assertInertia(
        fn (Inertia\Testing\AssertableInertia $page) => $page
            ->where('maxDowntimeActivities', Campaign::MAX_DOWNTIME_ACTIVITIES)
    );

    expect(Campaign::MAX_DOWNTIME_ACTIVITIES)->toEqual(3);
});

test('three activities are allowed without anything being opted into', function (): void {
    // A campaign straight out of the factory, with nothing set on it, because
    // there is no longer a flag that could be.
    $plain = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $hunter = Hunter::factory()->create(['campaign_id' => $plain->id]);

    downtimeDay($plain, [
        'hunter_day_id' => [$hunter->id => $this->activities->take(3)->pluck('id')->all()],
    ])->assertSessionHasNoErrors();

    expect($plain->days()->sole()->hunters()->count())->toEqual(3);
});
