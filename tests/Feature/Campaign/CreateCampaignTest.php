<?php

use App\Models\User;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
});

test('campaign can see create page', function (): void {
    $response = $this->get(route('campaigns.create'));
    $response->assertStatus(200);
});

test('campaign can create', function (): void {
    $response = $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Test Campaign',
        'description' => 'Test Campaign Description',
        'max_days' => 40,
    ]);
    $response->assertRedirect(route('campaigns.edit', 1));

    $campaign = Campaign::findOrFail(1);
    expect($campaign->team_id)->toEqual(1)
        ->and($campaign->name)->toEqual('Test Campaign')
        ->and($campaign->description)->toEqual('Test Campaign Description')
        ->and($campaign->max_days)->toEqual(40);
});
