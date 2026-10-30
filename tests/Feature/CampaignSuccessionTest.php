<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

// Who inherits a campaign when its owner deletes their account, and what that
// heir needs to be able to hold it. `DeleteAccountTest` covers the two
// outcomes (gone with the owner, or handed on); these pin the choice between
// several members and the heir that arrives with no team of their own.

function joinCampaign(Campaign $campaign, User $user, string $role): void
{
    $campaign->users()->attach($user, [
        'role_id' => Role::findByName($role, 'sanctum')->id,
    ]);
}

test('an admin inherits the campaign ahead of a member who joined earlier', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $owner->ownedTeams->first()->id]);

    $veteran = User::factory()->withPersonalTeam()->create();
    $admin = User::factory()->withPersonalTeam()->create();
    $this->travel(-2)->days();
    joinCampaign($campaign, $veteran, 'member-campaign');
    $this->travelBack();
    joinCampaign($campaign, $admin, 'admin-campaign');

    $this->actingAs($owner)->delete('/user', ['password' => 'password']);

    expect($campaign->fresh()->team->user_id)->toBe($admin->id)
        ->and($campaign->fresh()->team->personal_team)->toBeTrue();
});

test('without an admin the longest standing member inherits', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $owner->ownedTeams->first()->id]);

    $newcomer = User::factory()->withPersonalTeam()->create();
    $veteran = User::factory()->withPersonalTeam()->create();
    $this->travel(-2)->days();
    joinCampaign($campaign, $veteran, 'member-campaign');
    $this->travelBack();
    joinCampaign($campaign, $newcomer, 'member-campaign');

    $this->actingAs($owner)->delete('/user', ['password' => 'password']);

    expect($campaign->fresh()->team->user_id)->toBe($veteran->id);
});

test('an heir who owns no team is given one to hold the campaign', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $owner->ownedTeams->first()->id]);

    // What an account made through an invitation looks like: no team at all.
    $heir = User::factory()->create(['name' => 'Kiranico Smith']);
    joinCampaign($campaign, $heir, 'member-campaign');

    $this->actingAs($owner)->delete('/user', ['password' => 'password']);

    $team = $campaign->fresh()->team;

    expect($team->user_id)->toBe($heir->id)
        ->and($team->name)->toBe("Kiranico's Team")
        ->and($team->personal_team)->toBeTrue()
        ->and(Team::where('user_id', $heir->id)->count())->toBe(1);
});

test('an heir keeps the campaign under the personal team they already have', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $campaign = Campaign::factory()->create(['team_id' => $owner->ownedTeams->first()->id]);
    $heir = User::factory()->withPersonalTeam()->create();
    joinCampaign($campaign, $heir, 'admin-campaign');

    $this->actingAs($owner)->delete('/user', ['password' => 'password']);

    expect($campaign->fresh()->team_id)->toBe($heir->personalTeam()->id)
        ->and(Team::where('user_id', $heir->id)->count())->toBe(1);
});

test('the profile photo is removed from the disk with the account', function (): void {
    Storage::fake('public');
    config(['jetstream.profile_photo_disk' => 'public']);

    $user = User::factory()->withPersonalTeam()->create();
    $path = UploadedFile::fake()->image('me.png')->store('profile-photos', 'public');
    $user->forceFill(['profile_photo_path' => $path])->save();
    Storage::disk('public')->assertExists($path);

    $this->actingAs($user)->delete('/user', ['password' => 'password']);

    expect($user->fresh())->toBeNull();
    Storage::disk('public')->assertMissing($path);
});
