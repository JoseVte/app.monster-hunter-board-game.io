<?php

use App\Models\Day;
use App\Models\User;
use App\Models\Hunter;
use App\Models\Monster;
use App\Models\Campaign;
use App\Models\DowntimeActivity;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
});

test('campaign index redirects to the dashboard', function (): void {
    $response = $this->get(route('campaigns.index'));

    $response->assertRedirect(route('dashboard'));
});

test('campaign show renders the campaign page', function (): void {
    $response = $this->get(route('campaigns.show', $this->campaign));

    $response->assertStatus(200);
    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('Campaign/Show')
            ->where('campaign.id', $this->campaign->id)
            ->has('downtimeDays')
            ->has('monsters')
            ->has('availableRoles')
            ->has('permissions')
    );
});

test('campaign show exposes the permissions of the owner', function (): void {
    $response = $this->get(route('campaigns.show', $this->campaign));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->where('permissions.canUpdateCampaign', true)
            ->where('permissions.canDeleteCampaign', true)
            ->where('permissions.canAddCampaignMembers', true)
    );
});

test('campaign show loads the days with their monster and downtime activity', function (): void {
    $monster = Monster::factory()->create();
    $activity = DowntimeActivity::factory()->create();

    Day::factory()->create([
        'campaign_id' => $this->campaign->id,
        'number' => 1,
        'monster_id' => $monster->id,
    ]);
    Day::factory()->create([
        'campaign_id' => $this->campaign->id,
        'number' => 2,
        'downtime_activity_id' => $activity->id,
    ]);

    $response = $this->get(route('campaigns.show', $this->campaign));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->has('campaign.days', 2)
            ->where('campaign.days_count', 2)
            ->where('campaign.days.0.monster.id', $monster->id)
            ->where('campaign.days.1.downtime_activity.id', $activity->id)
    );
});

test('campaign show lists the members with their hunter', function (): void {
    $hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->campaign->users()->updateExistingPivot($this->user->id, ['hunter_id' => $hunter->id]);

    $response = $this->get(route('campaigns.show', $this->campaign));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->has('campaign.users', 1)
            ->where('campaign.users.0.membership.hunter.id', $hunter->id)
    );
});

test('campaign show switches the team when the campaign belongs to another one', function (): void {
    $otherUser = User::factory()->withPersonalTeam()->create();
    $otherTeam = $otherUser->currentTeam;
    $otherCampaign = Campaign::factory()->create(['team_id' => $otherTeam->id]);
    $otherTeam->users()->attach($this->user, ['role' => 'admin']);
    $otherCampaign->users()->attach($this->user->id, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);

    expect($this->user->current_team_id)->not->toEqual($otherTeam->id);

    $response = $this->get(route('campaigns.show', $otherCampaign));

    $response->assertRedirect(route('campaigns.show', $otherCampaign));
    expect($this->user->fresh()->current_team_id)->toEqual($otherTeam->id);
});
