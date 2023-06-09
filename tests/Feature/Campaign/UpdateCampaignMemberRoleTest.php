<?php

use App\Models\User;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;

test('campaign member roles can be updated', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);
    $campaign->users()->attach($user->id, [
        'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
    ]);

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'admin']
    );
    $campaign->users()->attach($otherUser->id, [
        'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
    ]);

    $response = $this->put(route('campaign-members.update', [$campaign, $otherUser]), [
        'role' => 'member-campaign',
    ]);

    $this->assertTrue($otherUser->fresh()->hasCampaignRole(
        $campaign->fresh(),
        'member-campaign'
    ));
});
