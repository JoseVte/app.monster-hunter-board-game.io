<?php

use App\Models\User;
use App\Enum\DayType;
use App\Models\Hunter;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterDifficulty;
use App\Models\DowntimeActivity;

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
    $this->assertEquals(1, $this->campaign->team_id);
    $this->assertEquals('Test Campaign', $this->campaign->name);
    $this->assertEquals('Test Campaign Description', $this->campaign->description);
    $this->assertEquals(40, $this->campaign->max_days);
    $this->assertEquals(2, $this->campaign->health_potions);
});

test('campaign can update potions', function (): void {
    $response = $this->put(route('campaigns.update-potions', $this->campaign), [
        'health_potions' => 1,
    ]);
    $response->assertStatus(303);

    $this->campaign->refresh();
    $this->assertEquals(1, $this->campaign->health_potions);
});

test('campaign can add hunt monster days', function (): void {
    Monster::factory(5)->create();

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    $this->assertEquals(1, $this->campaign->days()->count());

    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
        'hunted' => true,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    $this->assertEquals(2, $this->campaign->days()->count());
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
    $this->assertEquals(1, $this->campaign->days()->count());

    $hunterDays = Hunter::all()->keyBy('id')->map(fn () => DowntimeActivity::inRandomOrder()->firstOrFail()->id)->toArray();
    $response = $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'hunter_day_id' => $hunterDays,
        'all_hunters_same_activity' => false,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    $this->assertEquals(2, $this->campaign->days()->count());
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
    $this->assertEquals(1, $this->campaign->days()->count());

    $response = $this->put(route('campaigns.update-day', [$this->campaign, 1]), [
        'type_day' => DayType::DOWNTIME->name,
        'day_id' => DowntimeActivity::inRandomOrder()->firstOrFail()->id,
        'all_hunters_same_activity' => true,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    $this->assertEquals(1, $this->campaign->days()->count());
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
    $this->assertEquals(1, $this->campaign->days()->count());

    $response = $this->put(route('campaigns.update-day', [$this->campaign, 1]), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => Monster::inRandomOrder()->firstOrFail()->id,
        'difficulty' => Arr::random(MonsterDifficulty::cases())->name,
    ]);
    $response->assertSessionHasNoErrors();
    $response->assertStatus(303);

    $this->campaign->refresh();
    $this->assertEquals(1, $this->campaign->days()->count());
});
