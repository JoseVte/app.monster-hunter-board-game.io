<?php

use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
});

test('hunter can see create page', function (): void {
    $response = $this->get(route('campaigns.hunters.create', $this->campaign));
    $response->assertStatus(200);
});

test('hunter can create', function (): void {
    $response = $this->post(route('campaigns.hunters.store', $this->campaign), [
        'name' => 'Test Hunter',
    ]);
    $response->assertRedirect(route('campaigns.hunters.edit', [$this->campaign, 1]));

    $hunter = Hunter::findOrFail(1);
    $this->assertEquals($this->campaign->id, $hunter->campaign_id);
    $this->assertEquals('Test Hunter', $hunter->name);
});
