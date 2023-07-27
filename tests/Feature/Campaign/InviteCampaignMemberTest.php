<?php

use App\Models\User;
use App\Models\Campaign;
use Laravel\Jetstream\Features;
use App\Mail\CampaignInvitation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

test('campaign members can be invited to campaign', function (): void {
    if (!Features::sendsTeamInvitations()) {
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

    $this->assertCount(1, $campaign->fresh()->campaignInvitations);
});

test('campaign members invitations can be cancelled', function (): void {
    if (!Features::sendsTeamInvitations()) {
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

    $this->assertCount(1, $campaign->fresh()->campaignInvitations);
    $response = $this->delete(route('campaign-invitations.destroy', $invitation));

    $this->assertCount(0, $campaign->fresh()->campaignInvitations);
});
