<?php

use App\Models\User;
use App\Models\Campaign;
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

// RegisterInvitedUser creates the row and nothing else, while CreateNewUser and
// SocialAuthController both hand out a personal team and the `standard` role.
// An account that arrived through an invitation was therefore missing both, and
// a campaign is created against the owner's current team.
test('an invited account gets a personal team and the standard role', function (): void {
    ['token' => $token] = invite('jane@example.com');

    $this->post(route('invitations.accept', $token), acceptPayload());

    $user = User::where('email', 'jane@example.com')->firstOrFail();

    expect($user->ownedTeams()->count())->toBe(1)
        ->and($user->personalTeam())->not->toBeNull()
        ->and($user->hasRole('standard'))->toBeTrue();
});

// The point of the team is that it can be spent. `campaigns.store` requires a
// team_id that exists and belongs to the person asking, so without one an
// invited account had nothing valid to send and could not create a campaign at
// all. Verifying the address here keeps the test on that one question, since
// the route group is behind `verified` for reasons of its own.
test('an invited account can create a campaign against its own team', function (): void {
    ['token' => $token] = invite('jane@example.com');

    $this->post(route('invitations.accept', $token), acceptPayload());

    $user = User::where('email', 'jane@example.com')->firstOrFail();
    $user->markEmailAsVerified();

    $this->actingAs($user)
        ->post(route('campaigns.store'), [
            'team_id' => $user->personalTeam()->id,
            'name' => 'A first hunt',
            'description' => 'Something to do',
            'max_days' => 50,
        ])->assertSessionHasNoErrors();

    expect(Campaign::where('name', 'A first hunt')->exists())->toBeTrue();
});
