<?php

use App\Models\User;
use App\Models\Invitation;
use App\Mail\UserInvitation;
use Illuminate\Support\Facades\Mail;

beforeEach(function (): void {
    Mail::fake();
});

test('a user can invite somebody by email', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user)
        ->post(route('invitations.store'), ['email' => 'guest@example.com'])
        ->assertStatus(303);

    expect($user->sentInvitations()->count())->toEqual(1)
        ->and($user->sentInvitations()->first()->email)->toEqual('guest@example.com');

    Mail::assertSent(UserInvitation::class, fn ($mail) => $mail->hasTo('guest@example.com'));
});

test('an invitation without an address is a link to share by hand', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user)
        ->post(route('invitations.store'))
        ->assertStatus(303);

    expect($user->sentInvitations()->first()->email)->toBeNull();

    Mail::assertNothingSent();
});

test('the stored token is a hash and never the token itself', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user)->post(route('invitations.store'), ['email' => 'guest@example.com']);

    $sent = null;
    Mail::assertSent(UserInvitation::class, function ($mail) use (&$sent): bool {
        $sent = $mail;

        return true;
    });

    $token = str($sent->acceptUrl)->afterLast('/')->toString();

    expect(Invitation::first()->token)->not->toEqual($token)
        ->and(Invitation::first()->token)->toEqual(Invitation::hashToken($token));
});

test('inviting an address that already has an account is refused', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $existing = User::factory()->create();

    $this->actingAs($user)
        ->post(route('invitations.store'), ['email' => $existing->email])
        ->assertSessionHasErrors('email');

    expect(Invitation::count())->toEqual(0);
});

test('a user cannot hold more pending invitations than the limit', function (): void {
    config(['invitations.max_pending_per_user' => 2]);

    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user)->post(route('invitations.store'));
    $this->actingAs($user)->post(route('invitations.store'));

    $this->actingAs($user)
        ->post(route('invitations.store'))
        ->assertSessionHasErrors('email');

    expect(Invitation::count())->toEqual(2);
});

test('a revoked invitation frees a slot', function (): void {
    config(['invitations.max_pending_per_user' => 1]);

    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user)->post(route('invitations.store'));

    $this->actingAs($user)->delete(route('invitations.destroy', Invitation::first()));

    $this->actingAs($user)
        ->post(route('invitations.store'))
        ->assertSessionHasNoErrors();

    expect(Invitation::pending()->count())->toEqual(1);
});

test('inviting requires being signed in', function (): void {
    $this->post(route('invitations.store'))->assertRedirect(route('login'));
});
