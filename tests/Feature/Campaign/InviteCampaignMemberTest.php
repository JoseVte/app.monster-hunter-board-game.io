<?php

use App\Models\User;
use App\Models\Campaign;
use Laravel\Jetstream\Features;
use App\Mail\CampaignInvitation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

test('campaign members can be invited to campaign', function (): void {
    if (! Features::sendsTeamInvitations()) {
        $this->markTestSkipped('Team invitations not enabled.');

        return;
    }

    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $response = $this->post(route('campaign-members.store', $campaign), [
        'email' => 'test@example.com',
        'role' => 'admin-campaign',
    ]);

    Mail::assertSent(CampaignInvitation::class);

    expect($campaign->fresh()->campaignInvitations)->toHaveCount(1);
});

test('campaign members invitations can be cancelled', function (): void {
    if (! Features::sendsTeamInvitations()) {
        $this->markTestSkipped('Team invitations not enabled.');

        return;
    }

    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $invitation = $campaign->campaignInvitations()->create([
        'email' => 'test@example.com',
        'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
    ]);

    expect($campaign->fresh()->campaignInvitations)->toHaveCount(1);
    $response = $this->delete(route('campaign-invitations.destroy', $invitation));

    expect($campaign->fresh()->campaignInvitations)->toHaveCount(0);
});
