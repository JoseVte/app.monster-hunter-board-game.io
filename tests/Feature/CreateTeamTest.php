<?php

use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('teams can be created', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->post('/teams', [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(2)
        ->and($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
});
