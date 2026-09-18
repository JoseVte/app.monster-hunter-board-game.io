<?php

use App\Models\User;
use Laravel\Jetstream\Features;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Mail\TeamInvitation;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('team members can be invited to team', function (): void {
    if (! Features::sendsTeamInvitations()) {
        $this->markTestSkipped('Team invitations not enabled.');

        return;
    }

    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->post('/teams/'.$user->currentTeam->id.'/members', [
        'email' => 'test@example.com',
        'role' => 'admin',
    ]);

    Mail::assertSent(TeamInvitation::class);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(1);
});

test('team member invitations can be cancelled', function (): void {
    if (! Features::sendsTeamInvitations()) {
        $this->markTestSkipped('Team invitations not enabled.');

        return;
    }

    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $invitation = $user->currentTeam->teamInvitations()->create([
        'email' => 'test@example.com',
        'role' => 'admin',
    ]);

    $response = $this->delete('/team-invitations/'.$invitation->id);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(0);
});
