<?php

use App\Models\User;
use App\Models\Campaign;

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
