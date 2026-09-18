<?php

use App\Models\Team;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('teams can be deleted', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->ownedTeams()->save($team = Team::factory()->make([
        'personal_team' => false,
    ]));

    $team->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'test-role']
    );

    $response = $this->delete('/teams/'.$team->id);

    expect($team->fresh())->toBeNull()
        ->and($otherUser->fresh()->teams)->toHaveCount(0);
});

test('personal teams cant be deleted', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->delete('/teams/'.$user->currentTeam->id);

    expect($user->currentTeam->fresh())->not->toBeNull();
});
