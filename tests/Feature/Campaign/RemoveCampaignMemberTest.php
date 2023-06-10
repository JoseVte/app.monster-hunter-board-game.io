<?php

use App\Models\User;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;

test('campaign member can be removed from campaigns', function (): void {
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

    $this->assertCount(2, $campaign->fresh()->users);
    $response = $this->delete(route('campaign-members.destroy', [$campaign, $otherUser]));
    $this->assertCount(1, $campaign->fresh()->users);
    $response = $this->delete(route('campaign-members.destroy', [$campaign, $user]));
    $this->assertCount(0, $campaign->fresh()->users);
});
