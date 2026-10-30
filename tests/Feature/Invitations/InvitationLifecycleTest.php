<?php

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Actions\Invitations\AcceptInvitation;
use App\Actions\Invitations\CreateInvitation;
use App\Exceptions\InvitationNoLongerPendingException;

// What happens to an invitation after it is issued, and the account accepting
// it creates. Accepting is one transaction: the user and the mark on the
// invitation land together or not at all.

function issueInvitation(?string $email = 'guest@example.com'): array
{
    return app(CreateInvitation::class)(User::factory()->create(), $email);
}

function invitedAttributes(string $email = 'guest@example.com'): array
{
    return ['name' => 'Guest', 'email' => $email, 'password' => bcrypt('password')];
}

test('an invitation revoked while the form was open creates no account', function (): void {
    ['invitation' => $invitation] = issueInvitation();
    $before = User::count();

    // Revoked behind the back of the copy the caller is holding.
    Invitation::whereKey($invitation->id)->update(['revoked_at' => now()]);

    expect(fn () => app(AcceptInvitation::class)($invitation, invitedAttributes(), emailIsTrusted: false))
        ->toThrow(InvitationNoLongerPendingException::class, __('This invitation is no longer valid.'));

    expect(User::count())->toBe($before)
        ->and($invitation->fresh()->accepted_at)->toBeNull();
});

test('an invitation cannot be accepted twice', function (): void {
    ['invitation' => $invitation] = issueInvitation();

    $first = app(AcceptInvitation::class)($invitation, invitedAttributes(), emailIsTrusted: false);

    expect(fn () => app(AcceptInvitation::class)($invitation, invitedAttributes('second@example.com'), emailIsTrusted: false))
        ->toThrow(InvitationNoLongerPendingException::class);

    expect($invitation->fresh()->accepted_by_id)->toBe($first->id)
        ->and(User::where('email', 'second@example.com')->exists())->toBeFalse();
});

test('the registration form path turns a revoked invitation into a message on the login page', function (): void {
    ['invitation' => $invitation, 'token' => $token] = issueInvitation();

    // Pending when the form is looked up, gone by the time it is accepted:
    // the action is swapped for one that revokes first, which is the race the
    // lock in markAccepted exists for.
    $this->instance(AcceptInvitation::class, new class(app(App\Actions\Invitations\RegisterInvitedUser::class)) extends AcceptInvitation
    {
        public function __invoke(Invitation $invitation, array $attributes, bool $emailIsTrusted): User
        {
            Invitation::whereKey($invitation->id)->update(['revoked_at' => now()]);

            return parent::__invoke($invitation, $attributes, $emailIsTrusted);
        }
    });

    $this->post(route('invitations.accept', $token), [
        'name' => 'Guest',
        'email' => 'guest@example.com',
        'password' => 'Password-123456',
        'password_confirmation' => 'Password-123456',
        'captcha_token' => 'token',
    ])
        ->assertRedirect(route('login'))
        ->assertSessionHas('error', __('This invitation is no longer valid.'));

    $this->assertGuest();
    expect(User::where('email', 'guest@example.com')->exists())->toBeFalse();
});

test('an address a provider vouched for is verified at once and sends no verification mail', function (): void {
    Event::fake([Registered::class]);
    ['invitation' => $invitation] = issueInvitation();

    $user = app(AcceptInvitation::class)($invitation, invitedAttributes(), emailIsTrusted: true);

    expect($user->hasVerifiedEmail())->toBeTrue()
        ->and($user->hasRole('standard'))->toBeTrue();
    Event::assertNotDispatched(Registered::class);
});

test('an address nobody vouched for still has to be verified', function (): void {
    Event::fake([Registered::class]);
    ['invitation' => $invitation] = issueInvitation();

    $user = app(AcceptInvitation::class)($invitation, invitedAttributes(), emailIsTrusted: false);

    expect($user->hasVerifiedEmail())->toBeFalse();
    Event::assertDispatched(Registered::class, fn (Registered $event): bool => $event->user->is($user));
});

test('every invitation is in exactly one state', function (): void {
    ['invitation' => $pending] = issueInvitation('pending@example.com');
    ['invitation' => $accepted] = issueInvitation('accepted@example.com');
    ['invitation' => $revoked] = issueInvitation('revoked@example.com');
    ['invitation' => $expired] = issueInvitation('expired@example.com');
    ['invitation' => $revokedAfterExpiry] = issueInvitation('both@example.com');

    $accepted->forceFill(['accepted_at' => now()])->save();
    $revoked->forceFill(['revoked_at' => now()])->save();
    $expired->forceFill(['expires_at' => now()->subMinute()])->save();
    $revokedAfterExpiry->forceFill(['expires_at' => now()->subMinute(), 'revoked_at' => now()])->save();

    expect(Invitation::pending()->pluck('email')->all())->toBe(['pending@example.com'])
        ->and(Invitation::accepted()->pluck('email')->all())->toBe(['accepted@example.com'])
        ->and(Invitation::revoked()->pluck('email')->sort()->values()->all())->toBe(['both@example.com', 'revoked@example.com'])
        ->and(Invitation::expired()->pluck('email')->all())->toBe(['expired@example.com']);
});
