<?php

use App\Models\User;
use App\Models\Campaign;
use Laravel\Jetstream\Features;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

// With team invitations switched off, Jetstream's convention is to add an
// existing account straight away instead of mailing it. The app ships with
// invitations on, so this path only runs when the feature is turned off.

beforeEach(function (): void {
    // Declaring the feature again is how Jetstream stores its options.
    Features::teams(['invitations' => false]);
    Mail::fake();

    $this->actingAs($this->owner = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->owner->currentTeam->id]);
});

test('an existing account joins the campaign and its team at once', function (): void {
    expect(Features::sendsTeamInvitations())->toBeFalse();
    $player = User::factory()->create();

    $this->post(route('campaign-members.store', $this->campaign), [
        'email' => $player->email,
        'role' => 'member-campaign',
    ])->assertStatus(303)->assertSessionHasNoErrors();

    expect($player->fresh()->hasCampaignRole($this->campaign->fresh(), 'member-campaign'))->toBeTrue()
        ->and($this->campaign->team->fresh()->hasUser($player))->toBeTrue()
        ->and($this->campaign->campaignInvitations()->count())->toBe(0);
    Mail::assertNothingSent();
});

test('an address with no account cannot be added directly', function (): void {
    $this->post(route('campaign-members.store', $this->campaign), [
        'email' => 'nobody@example.com',
        'role' => 'member-campaign',
    ])->assertSessionHasErrors('email', errorBag: 'addCampaignMember');

    expect($this->campaign->users()->count())->toBe(1);
});

test('somebody already in the campaign is not added twice', function (): void {
    $player = User::factory()->create();
    $this->campaign->users()->attach($player, ['role_id' => Role::findByName('member-campaign', 'sanctum')->id]);

    $this->post(route('campaign-members.store', $this->campaign), [
        'email' => $player->email,
        'role' => 'admin-campaign',
    ])->assertSessionHasErrors('email', errorBag: 'addCampaignMember');

    expect($player->fresh()->hasCampaignRole($this->campaign->fresh(), 'admin-campaign'))->toBeFalse();
});

test('a member of the team keeps the team role they already had', function (): void {
    $player = User::factory()->create();
    $this->campaign->team->users()->attach($player, ['role' => 'admin']);

    $this->post(route('campaign-members.store', $this->campaign), [
        'email' => $player->email,
        'role' => 'member-campaign',
    ])->assertSessionHasNoErrors();

    expect($this->campaign->team->users()->where('users.id', $player->id)->first()->membership->role)->toBe('admin');
});
