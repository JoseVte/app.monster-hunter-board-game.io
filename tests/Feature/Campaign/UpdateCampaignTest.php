<?php

use App\Models\User;
use App\Models\Campaign;

test('campaign can see edit page', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $response = $this->get('/campaigns/'.$campaign->id.'/edit');
    $response->assertStatus(200);
});

test('campaign can update', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $response = $this->put('/campaigns/'.$campaign->id, [
        'name' => 'Test Campaign',
        'description' => 'Test Campaign Description',
        'max_days' => 40,
        'health_potions' => 2,
    ]);
    $response->assertStatus(303);

    $campaign->refresh();
    $this->assertEquals(1, $campaign->team_id);
    $this->assertEquals('Test Campaign', $campaign->name);
    $this->assertEquals('Test Campaign Description', $campaign->description);
    $this->assertEquals(40, $campaign->max_days);
    $this->assertEquals(2, $campaign->health_potions);
});

test('campaign can update potions', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $response = $this->put('/campaigns/'.$campaign->id.'/update-potions', [
        'health_potions' => 1,
    ]);
    $response->assertStatus(303);

    $campaign->refresh();
    $this->assertEquals(1, $campaign->health_potions);
});
