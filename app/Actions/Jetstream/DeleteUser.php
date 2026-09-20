<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * The team deleter implementation.
     *
     * @var DeletesTeams
     */
    protected $deletesTeams;

    /**
     * Create a new action instance.
     */
    public function __construct(DeletesTeams $deletesTeams)
    {
        $this->deletesTeams = $deletesTeams;
    }

    /**
     * Delete the given user.
     *
     * The campaigns have to be resolved before the teams are purged. A campaign
     * belongs to a team through a foreign key declared without an `onDelete`,
     * so deleting a team that still owns one raises a constraint violation,
     * rolls the whole transaction back, and leaves the account standing. That
     * was the previous behaviour for every user who had ever created a
     * campaign, which is to say every real user.
     */
    public function delete($user): void
    {
        DB::transaction(function () use ($user): void {
            $this->resolveOwnedCampaigns($user);
            $this->deleteTeams($user);
            $this->deleteProfilePhoto($user);

            $user->campaigns()->detach();
            $this->forgetTraces($user);

            $user->providers->each->delete();
            $user->tokens->each->delete();
            $user->delete();
        });
    }

    /**
     * Hand each owned campaign to another member, or delete it if there is none.
     */
    protected function resolveOwnedCampaigns(User $user): void
    {
        $user->ownedTeams()->with('campaigns')->get()
            ->each(fn (Team $team) => $team->campaigns
                ->each(function (Campaign $campaign) use ($user): void {
                    $heir = $this->heirFor($campaign, $user);

                    if ($heir === null) {
                        $campaign->purge();

                        return;
                    }

                    $campaign->team()->associate($this->teamFor($heir))->save();
                    $campaign->users()->detach($user->id);
                }));
    }

    /**
     * The member a campaign should pass to: the longest standing admin, or
     * failing that the longest standing member. Null when nobody else is left,
     * which is the only case where the campaign is the leaving user's alone to
     * take with them.
     */
    protected function heirFor(Campaign $campaign, User $user): ?User
    {
        $members = $campaign->users()
            ->where('users.id', '!=', $user->id)
            ->orderBy('campaign_user.created_at')
            ->orderBy('users.id')
            ->get();

        if ($members->isEmpty()) {
            return null;
        }

        $admin = Role::where('name', 'admin-campaign')
            ->where('guard_name', 'sanctum')
            ->value('id');

        return $members->first(fn (User $member): bool => $member->membership->role_id === $admin)
            ?? $members->first();
    }

    /**
     * The team a campaign handed to this member should sit under.
     *
     * Registering through Fortify or a social provider creates a personal team,
     * but RegisterInvitedUser does not, so an account that arrived through an
     * invitation can own no team at all and one has to be made for it.
     */
    protected function teamFor(User $heir): Team
    {
        $team = $heir->ownedTeams()->orderByDesc('personal_team')->first();

        if ($team !== null) {
            return $team;
        }

        return Team::forceCreate([
            'user_id' => $heir->id,
            'name' => explode(' ', $heir->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]);
    }

    /**
     * Remove what the account leaves behind outside its own row.
     *
     * Sessions carry an IP address and a user agent, and a pending reset token
     * is keyed by the address itself. Neither has a foreign key to `users`, so
     * neither goes anywhere on its own.
     *
     * The three invitation tables all store the address in clear, and it
     * outlives the account in two ways: `invitations.accepted_by_id` is nulled
     * on delete while the row and its `email` stay, and an invitation a third
     * party addressed to that person was never tied to their account at all.
     * Both are deleted here. An invitation still pending to an address that
     * asked to be forgotten is not something to keep on the inviter's behalf.
     */
    protected function forgetTraces(User $user): void
    {
        DB::table('sessions')->where('user_id', $user->id)->delete();
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        DB::table('invitations')->where('email', $user->email)->delete();
        DB::table('team_invitations')->where('email', $user->email)->delete();
        DB::table('campaign_invitations')->where('email', $user->email)->delete();
    }

    /**
     * Jetstream's own deleteProfilePhoto() returns without doing anything
     * unless the profilePhotos feature is enabled, and it is commented out in
     * config/jetstream.php. Its upload counterpart carries no such guard and is
     * reachable through Fortify's profile-information route, so a photo can
     * exist on a public disk that nothing would ever remove.
     */
    protected function deleteProfilePhoto(User $user): void
    {
        if (blank($user->profile_photo_path)) {
            return;
        }

        Storage::disk(config('jetstream.profile_photo_disk', 'public'))
            ->delete($user->profile_photo_path);
    }

    /**
     * Delete the teams and team associations attached to the user.
     */
    protected function deleteTeams($user): void
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function ($team): void {
            $this->deletesTeams->delete($team);
        });
    }
}
