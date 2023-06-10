<?php

use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;

test('hunters can be deleted', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);
    $hunter = Hunter::factory()->create(['campaign_id' => $campaign->id]);

    $response = $this->delete(route('campaigns.hunters.destroy', [$campaign, $hunter]));
    $response->assertRedirectToRoute('campaigns.show', $campaign);

    $this->assertEquals(0, Hunter::count());
});
