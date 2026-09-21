<?php

use App\Models\User;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use App\Actions\Invitations\CreateInvitation;
use Illuminate\Auth\Notifications\ResetPassword;

// Every form a stranger can post to sends mail or creates an account, and until
// now only login and register asked Google anything. `forgot-password` was the
// worst of them: no captcha, and Fortify applies no rate limit to it either, so
// it would send a reset email to any address, as often as asked.

test('a password reset request without a captcha token is refused', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertNothingSent();
});

test('a password reset request with a captcha token goes through', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email, 'captcha_token' => 'a-token']);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('accepting a platform invitation without a captcha token is refused', function (): void {
    $inviter = User::factory()->withPersonalTeam()->create();
    ['token' => $token] = app(CreateInvitation::class)($inviter, 'jane@example.com');

    $this->post(route('invitations.accept', $token), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'a-long-enough-password',
        'password_confirmation' => 'a-long-enough-password',
    ]);

    expect(User::where('email', 'jane@example.com')->exists())->toBeFalse();
});

test('accepting a campaign invitation without a captcha token is refused', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $owner->currentTeam->id]);

    $invitation = $campaign->campaignInvitations()->create([
        'email' => 'jane@example.com',
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);

    $this->post(URL::signedRoute('campaign-invitations.register', ['invitation' => $invitation]), [
        'name' => 'Jane Doe',
        'password' => 'a-long-enough-password',
        'password_confirmation' => 'a-long-enough-password',
    ]);

    expect(User::where('email', 'jane@example.com')->exists())->toBeFalse();
});
