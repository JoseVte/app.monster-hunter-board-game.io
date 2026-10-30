<?php

use App\Models\User;
use App\Models\Campaign;
use App\Mail\TestMessage;
use App\Mail\UserInvitation;
use Laravel\Fortify\Features;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;
use App\Actions\Invitations\CreateInvitation;
use App\Mail\CampaignInvitation as CampaignInvitationMail;

// The suite fakes the mailer everywhere else, so the messages themselves were
// never rendered. What matters in them is the link: it is the only way in for
// somebody who has no account yet, and a link that does not open is the same
// as no invitation.

function campaignInvitationFor(string $email): App\Models\CampaignInvitation
{
    $owner = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $owner->currentTeam->id, 'name' => 'Ancient Forest Run']);

    return $campaign->campaignInvitations()->create([
        'email' => $email,
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);
}

function linkIn(string $html, string $needle): string
{
    preg_match_all('/href="([^"]+)"/', $html, $matches);

    return html_entity_decode(collect($matches[1])->first(fn (string $href): bool => str_contains($href, $needle)));
}

test('the campaign invitation names the campaign and carries a signed link that opens', function (): void {
    $mail = new CampaignInvitationMail(campaignInvitationFor('newcomer@example.com'));
    $html = $mail->render();

    $mail->assertHasSubject('Campaign Invitation');
    expect($html)->toContain('Ancient Forest Run');

    $link = linkIn($html, '/campaign-invitations/');

    expect($link)->toBe($mail->acceptUrl)
        ->and($link)->toContain('signature=');

    $this->get($link)
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Auth/AcceptCampaignInvitation')
            ->where('email', 'newcomer@example.com')
            ->where('campaign', 'Ancient Forest Run'));
});

test('a campaign invitation link that was tampered with is refused', function (): void {
    $mail = new CampaignInvitationMail(campaignInvitationFor('newcomer@example.com'));
    $other = campaignInvitationFor('someone-else@example.com');

    $forged = preg_replace('#/campaign-invitations/\d+#', '/campaign-invitations/'.$other->id, $mail->acceptUrl);

    $this->get($forged)->assertForbidden();
});

test('the campaign invitation only offers to create an account while registration is open', function (): void {
    $invitation = campaignInvitationFor('newcomer@example.com');

    expect((new CampaignInvitationMail($invitation))->render())->not->toContain(__('Create Account'));

    config(['fortify.features' => [...config('fortify.features'), Features::registration()]]);
    app('router')->get('/register-for-mail-test', fn () => '')->name('register');
    app('router')->getRoutes()->refreshNameLookups();

    expect((new CampaignInvitationMail($invitation))->render())->toContain(__('Create Account'));
});

test('the platform invitation names who sent it, when it runs out and a link with the raw token', function (): void {
    $inviter = User::factory()->withPersonalTeam()->create(['name' => 'Commander']);
    ['invitation' => $invitation, 'token' => $token] = app(CreateInvitation::class)($inviter, 'friend@example.com');

    $mail = new UserInvitation($invitation, $token);
    $html = $mail->render();

    $mail->assertHasSubject(__('You have been invited to :app', ['app' => config('app.name')]));
    expect($html)
        ->toContain('Commander')
        ->toContain($invitation->expires_at->toFormattedDateString())
        ->not->toContain($invitation->token);

    $this->get(linkIn($html, '/invite/'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Auth/AcceptInvitation')
            ->where('email', 'friend@example.com')
            ->where('inviter', 'Commander'));
});

test('the test message says which mailer carried it', function (): void {
    $mail = new TestMessage('smtp');

    $mail->assertHasSubject(__('Mail test from :app', ['app' => config('app.name')]));
    $mail->assertSeeInHtml('smtp');
});
