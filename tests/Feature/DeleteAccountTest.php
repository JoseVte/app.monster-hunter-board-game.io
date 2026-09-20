<?php

use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;
use Laravel\Jetstream\Features;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Actions\Invitations\CreateInvitation;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user accounts can be deleted', function (): void {
    if (! Features::hasAccountDeletionFeatures()) {
        $this->markTestSkipped('Account deletion is not enabled.');

        return;
    }

    $this->actingAs($user = User::factory()->create());

    $response = $this->delete('/user', [
        'password' => 'password',
    ]);

    expect($user->fresh())->toBeNull();
});

test('correct password must be provided before account can be deleted', function (): void {
    if (! Features::hasAccountDeletionFeatures()) {
        $this->markTestSkipped('Account deletion is not enabled.');

        return;
    }

    $this->actingAs($user = User::factory()->create());

    $response = $this->delete('/user', [
        'password' => 'wrong-password',
    ]);

    expect($user->fresh())->not->toBeNull();
});

// Deleting an account used to fail outright for anyone who had created a
// campaign: DeleteUser purges the owned teams, `campaigns.team_id` is
// constrained without an onDelete, and the foreign key took the whole
// transaction down with it. The account survived, which is the one outcome the
// right to erasure does not allow. The two tests above never caught it because
// `User::factory()->create()` has no personal team, so Team::purge never runs.

test('a campaign the user owned alone goes with their account', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $user->ownedTeams->first()->id]);
    $hunter = Hunter::factory()->create(['campaign_id' => $campaign->id]);

    $this->actingAs($user)->delete('/user', ['password' => 'password']);

    expect($user->fresh())->toBeNull()
        ->and(Campaign::find($campaign->id))->toBeNull()
        ->and(Hunter::find($hunter->id))->toBeNull();
});

test('a campaign with other members is handed to one of them', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $member = User::factory()->withPersonalTeam()->create();

    $campaign = Campaign::factory()->create(['team_id' => $owner->ownedTeams->first()->id]);
    $campaign->users()->attach($member, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);

    $this->actingAs($owner)->delete('/user', ['password' => 'password']);

    $survivor = Campaign::find($campaign->id);

    expect($owner->fresh())->toBeNull()
        ->and($survivor)->not->toBeNull()
        ->and($member->fresh()->ownsCampaign($survivor))->toBeTrue()
        ->and($survivor->users()->where('users.id', $owner->id)->exists())->toBeFalse();
});

test('deleting an account leaves no session or password reset token behind', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    DB::table('sessions')->insert([
        'id' => 'a-session', 'user_id' => $user->id, 'ip_address' => '203.0.113.1',
        'user_agent' => 'a browser', 'payload' => 'x', 'last_activity' => time(),
    ]);
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email, 'token' => 'x', 'created_at' => now(),
    ]);

    $this->actingAs($user)->delete('/user', ['password' => 'password']);

    expect(DB::table('sessions')->where('user_id', $user->id)->count())->toBe(0)
        ->and(DB::table('password_reset_tokens')->where('email', $user->email)->count())->toBe(0);
});

// The three invitation tables store the address in clear and neither is tied to
// the account: `invitations.accepted_by_id` is nulled on delete while the row
// and its email stay, and an invitation a third party addressed to that person
// was never linked to their account in the first place.
test('deleting an account takes the invitations that carry its address', function (): void {
    $inviter = User::factory()->withPersonalTeam()->create();
    ['invitation' => $sent] = app(CreateInvitation::class)($inviter, 'jane@example.com');

    $jane = User::factory()->withPersonalTeam()->create(['email' => 'jane@example.com']);
    $sent->forceFill(['accepted_by_id' => $jane->id, 'accepted_at' => now()])->save();

    DB::table('team_invitations')->insert([
        'team_id' => $inviter->ownedTeams->first()->id,
        'email' => 'jane@example.com',
        'role' => 'editor',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->actingAs($jane)->delete('/user', ['password' => 'password']);

    expect(DB::table('invitations')->where('email', 'jane@example.com')->count())->toBe(0)
        ->and(DB::table('team_invitations')->where('email', 'jane@example.com')->count())->toBe(0);
});
