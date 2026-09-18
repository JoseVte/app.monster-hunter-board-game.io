<?php

use App\Models\User;
use App\Enum\DayType;
use App\Models\Hunter;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterDifficulty;
use App\Models\DowntimeActivity;
use App\Events\UserMonsterHunted;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
});

test('campaign can see edit page', function (): void {
    $response = $this->get(route('campaigns.edit', $this->campaign));
    $response->assertStatus(200);
});

test('campaign can update', function (): void {
    $response = $this->put(route('campaigns.update', $this->campaign), [
        'name' => 'Test Campaign',
        'description' => 'Test Campaign Description',
        'max_days' => 40,
        'health_potions' => 2,
    ]);
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->team_id)->toEqual(1)
        ->and($this->campaign->name)->toEqual('Test Campaign')
        ->and($this->campaign->description)->toEqual('Test Campaign Description')
        ->and($this->campaign->max_days)->toEqual(40)
        ->and($this->campaign->health_potions)->toEqual(2);
});

test('campaign can update potions', function (): void {
    $response = $this->put(route('campaigns.update-potions', $this->campaign), [
        'health_potions' => 1,
    ]);
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->health_potions)->toEqual(1);
});

test('campaign can add hunt monster days', function (): void {
    Event::fake(UserMonsterHunted::class);
    Monster::factory(5)->create();

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(1);

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
        'hunted' => true,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(2);
    Event::assertDispatchedTimes(UserMonsterHunted::class);
});

test('campaign can add downtime activity days', function (): void {
    DowntimeActivity::factory(5)->create();
    Hunter::factory(5)->create(['campaign_id' => $this->campaign->id]);

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'day_id' => DowntimeActivity::inRandomOrder()->firstOrFail()->id,
        'all_hunters_same_activity' => true,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(1);

    $hunterDays = Hunter::all()->keyBy('id')->map(fn () => DowntimeActivity::inRandomOrder()->firstOrFail()->id)->toArray();
    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'hunter_day_id' => $hunterDays,
        'all_hunters_same_activity' => false,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(2);
});

test('campaign can update hunt monster days to downtime activity day', function (): void {
    Monster::factory(5)->create();
    DowntimeActivity::factory(5)->create();
    Hunter::factory(5)->create(['campaign_id' => $this->campaign->id]);

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(1);

    $response = $this->put(route('campaigns.update-day', [$this->campaign, 1]), [
        'type_day' => DayType::DOWNTIME->name,
        'day_id' => DowntimeActivity::inRandomOrder()->firstOrFail()->id,
        'all_hunters_same_activity' => true,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(1);
});

test('campaign can update downtime activity days to hunt monster day', function (): void {
    Monster::factory(5)->create();
    DowntimeActivity::factory(5)->create();
    Hunter::factory(5)->create(['campaign_id' => $this->campaign->id]);

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'day_id' => DowntimeActivity::inRandomOrder()->firstOrFail()->id,
        'all_hunters_same_activity' => true,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(1);

    $response = $this->put(route('campaigns.update-day', [$this->campaign, 1]), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    expect($this->campaign->days()->count())->toEqual(1);
});

test('a day rejects an unknown type', function (): void {
    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => 'PICNIC',
    ]);

    $response->assertSessionHasErrors('type_day', errorBag: 'addOrUpdateCampaignDay');
    expect($this->campaign->days()->count())->toEqual(0);
});

test('a day rejects a missing type', function (): void {
    $response = $this->put(route('campaigns.add-day', $this->campaign), []);

    $response->assertSessionHasErrors('type_day', errorBag: 'addOrUpdateCampaignDay');
    expect($this->campaign->days()->count())->toEqual(0);
});

test('a monster day still requires its monster and difficulty', function (): void {
    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
    ]);

    $response->assertSessionHasErrors(['monster_id', 'difficulty'], errorBag: 'addOrUpdateCampaignDay');
    expect($this->campaign->days()->count())->toEqual(0);
});
