<?php

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Actions\Invitations\CreateInvitation;
use Illuminate\Auth\Notifications\VerifyEmail;

function invite(?string $email = null): array
{
    $inviter = User::factory()->withPersonalTeam()->create();

    return app(CreateInvitation::class)($inviter, $email);
}

function acceptPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'a-long-enough-password',
        'password_confirmation' => 'a-long-enough-password',
    ], $overrides);
}

test('a pending invitation shows the acceptance form', function (): void {
    ['token' => $token, 'invitation' => $invitation] = invite('jane@example.com');

    $this->get(route('invitations.show', $token))
        ->assertInertia(fn ($page) => $page
            ->component('Auth/AcceptInvitation')
            ->where('email', 'jane@example.com')
            ->where('inviter', $invitation->inviter->name));
});

test('accepting creates the account and signs the person in', function (): void {
    ['token' => $token] = invite('jane@example.com');

    $this->post(route('invitations.accept', $token), acceptPayload())
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();

    $user = User::where('email', 'jane@example.com')->firstOrFail();
    expect($user->name)->toEqual('Jane Doe')
        ->and(Invitation::first()->accepted_by_id)->toEqual($user->id)
        ->and(Invitation::first()->status)->toEqual('accepted');
});

test('the new account still has to verify its address', function (): void {
    Notification::fake();

    ['token' => $token] = invite('jane@example.com');

    $this->post(route('invitations.accept', $token), acceptPayload());

    $user = User::where('email', 'jane@example.com')->firstOrFail();

    expect($user->hasVerifiedEmail())->toBeFalse();
    Notification::assertSentTo($user, VerifyEmail::class);
});

test('an invitation addressed to somebody cannot be redeemed by another address', function (): void {
    ['token' => $token] = invite('jane@example.com');

    $this->post(route('invitations.accept', $token), acceptPayload(['email' => 'someone-else@example.com']))
        ->assertSessionHasErrors('email');

    expect(User::where('email', 'someone-else@example.com')->exists())->toBeFalse()
        ->and(Invitation::first()->status)->toEqual('pending');
});

test('an invitation with no address accepts any email', function (): void {
    ['token' => $token] = invite();

    $this->post(route('invitations.accept', $token), acceptPayload(['email' => 'anyone@example.com']))
        ->assertRedirect(route('dashboard', absolute: false));

    expect(User::where('email', 'anyone@example.com')->exists())->toBeTrue();
});

test('the same invitation cannot be used twice', function (): void {
    ['token' => $token] = invite();

    $this->post(route('invitations.accept', $token), acceptPayload(['email' => 'first@example.com']));
    $this->post('/logout');

    $this->post(route('invitations.accept', $token), acceptPayload(['email' => 'second@example.com']))
        ->assertRedirect(route('login'));

    expect(User::where('email', 'second@example.com')->exists())->toBeFalse();
});

test('a revoked invitation is refused', function (): void {
    ['token' => $token, 'invitation' => $invitation] = invite();
    $invitation->forceFill(['revoked_at' => now()])->save();

    $this->get(route('invitations.show', $token))->assertRedirect(route('login'));
    $this->post(route('invitations.accept', $token), acceptPayload())->assertRedirect(route('login'));

    expect(User::where('email', 'jane@example.com')->exists())->toBeFalse();
});

test('an expired invitation is refused', function (): void {
    ['token' => $token, 'invitation' => $invitation] = invite();
    $invitation->forceFill(['expires_at' => now()->subDay()])->save();

    $this->get(route('invitations.show', $token))->assertRedirect(route('login'));

    expect(Invitation::first()->status)->toEqual('expired');
});

test('an unknown token is refused', function (): void {
    $this->get(route('invitations.show', Invitation::newToken()))->assertRedirect(route('login'));
});

test('the raw token does not open the invitation, only its hash matches', function (): void {
    ['invitation' => $invitation] = invite();

    $this->get(route('invitations.show', $invitation->token))->assertRedirect(route('login'));
});

test('the password has to be confirmed', function (): void {
    ['token' => $token] = invite();

    $this->post(route('invitations.accept', $token), acceptPayload(['password_confirmation' => 'something-else']))
        ->assertSessionHasErrors('password');

    expect(User::count())->toEqual(1);
});

test('the password is stored hashed', function (): void {
    ['token' => $token] = invite();

    $this->post(route('invitations.accept', $token), acceptPayload());

    $user = User::where('email', 'jane@example.com')->firstOrFail();

    expect($user->password)->not->toEqual('a-long-enough-password')
        ->and(Hash::check('a-long-enough-password', $user->password))->toBeTrue();
});
