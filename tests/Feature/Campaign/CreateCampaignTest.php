<?php

use App\Models\User;
use App\Models\Campaign;

test('campaign can see create page', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->get('/campaigns/create');
    $response->assertStatus(200);
});

test('campaign can create', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->post('/campaigns', [
        'team_id' => $user->currentTeam->id,
        'name' => 'Test Campaign',
        'description' => 'Test Campaign Description',
        'max_days' => 40,
    ]);
    $response->assertRedirect(route('campaigns.edit', 1));

    $campaign = Campaign::findOrFail(1);
    $this->assertEquals(1, $campaign->team_id);
    $this->assertEquals('Test Campaign', $campaign->name);
    $this->assertEquals('Test Campaign Description', $campaign->description);
    $this->assertEquals(40, $campaign->max_days);
});
