<?php

use App\Models\User;
use App\Models\Campaign;

test('campaigns can be deleted', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $response = $this->delete(route('campaigns.destroy', $campaign));
    $response->assertRedirectToRoute('dashboard');

    expect(Campaign::count())->toEqual(0);
});
