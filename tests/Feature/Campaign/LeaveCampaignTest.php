<?php

use App\Models\User;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;

test('users can leave campaigns', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'admin']
    );
    $campaign->users()->attach($otherUser->id, [
        'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
    ]);

    $this->actingAs($otherUser);

    $this->assertCount(2, $campaign->fresh()->users);
    $response = $this->delete(route('campaign-members.destroy', [$campaign, $otherUser]));
    $this->assertCount(1, $campaign->fresh()->users);
    $this->actingAs($user);
    $response = $this->delete(route('campaign-members.destroy', [$campaign, $user]));
    $this->assertCount(0, $campaign->fresh()->users);
});
