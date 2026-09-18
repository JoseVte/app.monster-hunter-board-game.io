<?php

use App\Models\User;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;

test('campaign member can be removed from campaigns', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'admin']
    );
    $campaign->users()->attach($otherUser->id, [
        'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
    ]);

    expect($campaign->fresh()->users)->toHaveCount(2);
    $response = $this->delete(route('campaign-members.destroy', [$campaign, $otherUser]));
    expect($campaign->fresh()->users)->toHaveCount(1);
    $response = $this->delete(route('campaign-members.destroy', [$campaign, $user]));
    expect($campaign->fresh()->users)->toHaveCount(0);
});
