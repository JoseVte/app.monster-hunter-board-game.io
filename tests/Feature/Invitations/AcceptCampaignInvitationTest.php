<?php

use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignInvitation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

beforeEach(function (): void {
    $this->owner = User::factory()->withPersonalTeam()->create();
    $this->campaign = Campaign::factory()->create(['team_id' => $this->owner->currentTeam->id]);

    $this->invitation = $this->campaign->campaignInvitations()->create([
        'email' => 'guest@example.com',
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);

    $this->link = fn (CampaignInvitation $invitation) => URL::signedRoute('campaign-invitations.accept', ['invitation' => $invitation]);
});

test('somebody with no account is offered the form rather than a login wall', function (): void {
    $this->get(($this->link)($this->invitation))
        ->assertInertia(fn ($page) => $page
            ->component('Auth/AcceptCampaignInvitation')
            ->where('email', 'guest@example.com')
            ->where('campaign', $this->campaign->name));
});

test('accepting creates the account and joins the campaign', function (): void {
    $this->post(URL::signedRoute('campaign-invitations.register', ['invitation' => $this->invitation]), [
        'name' => 'Jane Doe',
        'password' => 'a-long-enough-password',
        'password_confirmation' => 'a-long-enough-password',
    ])->assertRedirect(config('fortify.home'));

    $this->assertAuthenticated();

    $user = User::where('email', 'guest@example.com')->firstOrFail();

    expect($user->name)->toEqual('Jane Doe')
        ->and($this->campaign->fresh()->users()->find($user->id))->not->toBeNull()
        ->and(CampaignInvitation::count())->toEqual(0);
});

test('the new account still has to verify its address', function (): void {
    Notification::fake();

    $this->post(URL::signedRoute('campaign-invitations.register', ['invitation' => $this->invitation]), [
        'name' => 'Jane Doe',
        'password' => 'a-long-enough-password',
        'password_confirmation' => 'a-long-enough-password',
    ]);

    $user = User::where('email', 'guest@example.com')->firstOrFail();

    expect($user->hasVerifiedEmail())->toBeFalse();
    Notification::assertSentTo($user, VerifyEmail::class);
});

test('an existing account is sent to sign in first', function (): void {
    User::factory()->withPersonalTeam()->create(['email' => 'guest@example.com']);

    $this->get(($this->link)($this->invitation))->assertRedirect(route('login'));
});

test('an existing account that is signed in joins straight away', function (): void {
    $guest = User::factory()->withPersonalTeam()->create(['email' => 'guest@example.com']);

    $this->actingAs($guest)
        ->get(($this->link)($this->invitation))
        ->assertRedirect(config('fortify.home'));

    expect($this->campaign->fresh()->users()->find($guest->id))->not->toBeNull()
        ->and(CampaignInvitation::count())->toEqual(0);
});

test('somebody else holding the link cannot join in the invited person place', function (): void {
    User::factory()->withPersonalTeam()->create(['email' => 'guest@example.com']);
    $stranger = User::factory()->withPersonalTeam()->create();

    $this->actingAs($stranger)
        ->get(($this->link)($this->invitation))
        ->assertRedirect(route('dashboard'));

    expect($this->campaign->fresh()->users()->count())->toEqual(1)
        ->and(CampaignInvitation::count())->toEqual(1);
});

test('the registration form refuses once the address has an account', function (): void {
    User::factory()->withPersonalTeam()->create(['email' => 'guest@example.com']);

    $this->post(URL::signedRoute('campaign-invitations.register', ['invitation' => $this->invitation]), [
        'name' => 'Impostor',
        'password' => 'a-long-enough-password',
        'password_confirmation' => 'a-long-enough-password',
    ])->assertRedirect(route('login'));

    expect(User::where('name', 'Impostor')->exists())->toBeFalse();
});

test('an unsigned link is refused', function (): void {
    $this->get(route('campaign-invitations.accept', ['invitation' => $this->invitation]))
        ->assertForbidden();
});
