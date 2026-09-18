<?php

use App\Models\User;
use App\Models\Invitation;
use App\Mail\UserInvitation;
use Illuminate\Support\Facades\Mail;
use App\Actions\Invitations\CreateInvitation;

beforeEach(function (): void {
    Mail::fake();
});

test('the sender can revoke their own invitation', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    ['invitation' => $invitation] = app(CreateInvitation::class)($user);

    $this->actingAs($user)
        ->delete(route('invitations.destroy', $invitation))
        ->assertStatus(303);

    expect($invitation->fresh()->status)->toEqual('revoked');
});

test('somebody else cannot revoke an invitation they did not send', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $stranger = User::factory()->withPersonalTeam()->create();
    ['invitation' => $invitation] = app(CreateInvitation::class)($owner);

    $this->actingAs($stranger)
        ->delete(route('invitations.destroy', $invitation))
        ->assertForbidden();

    expect($invitation->fresh()->status)->toEqual('pending');
});

test('resending replaces the invitation so the old link stops working', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    ['invitation' => $original, 'token' => $originalToken] = app(CreateInvitation::class)($user, 'guest@example.com');

    $this->actingAs($user)
        ->put(route('invitations.resend', $original))
        ->assertStatus(303);

    expect($original->fresh()->status)->toEqual('revoked')
        ->and(Invitation::pending()->count())->toEqual(1)
        ->and(Invitation::pending()->first()->email)->toEqual('guest@example.com');

    $this->get(route('invitations.show', $originalToken))->assertRedirect(route('login'));

    // Creating through the action does not send; only the controller does, so
    // the resend accounts for the single mail here.
    Mail::assertSent(UserInvitation::class, 1);
});

test('somebody else cannot resend an invitation they did not send', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $stranger = User::factory()->withPersonalTeam()->create();
    ['invitation' => $invitation] = app(CreateInvitation::class)($owner);

    $this->actingAs($stranger)
        ->put(route('invitations.resend', $invitation))
        ->assertForbidden();

    expect(Invitation::count())->toEqual(1);
});

test('the status is derived, so revoking beats having been accepted', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    ['invitation' => $invitation] = app(CreateInvitation::class)($user);

    $invitation->forceFill(['accepted_at' => now(), 'revoked_at' => now()])->save();

    expect($invitation->fresh()->status)->toEqual('revoked');
});

test('the token never reaches the frontend', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    ['invitation' => $invitation] = app(CreateInvitation::class)($user);

    expect($invitation->toArray())->not->toHaveKey('token')
        ->and($invitation->toArray())->toHaveKey('status');
});

test('the profile page carries the invitations and the limit', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    app(CreateInvitation::class)($user, 'guest@example.com');

    $this->actingAs($user)
        ->get(route('profile.show'))
        ->assertInertia(fn ($page) => $page
            ->component('Profile/Show')
            ->has('invitations', 1)
            ->where('invitations.0.email', 'guest@example.com')
            ->where('invitations.0.status', 'pending')
            ->where('invitationLimit', config('invitations.max_pending_per_user')));
});

test('the profile page never shows somebody else invitations', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $stranger = User::factory()->withPersonalTeam()->create();
    app(CreateInvitation::class)($stranger, 'guest@example.com');

    $this->actingAs($user)
        ->get(route('profile.show'))
        ->assertInertia(fn ($page) => $page->has('invitations', 0));
});
