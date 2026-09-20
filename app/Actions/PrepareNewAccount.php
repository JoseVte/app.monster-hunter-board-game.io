<?php

namespace App\Actions;

use App\Models\Team;
use App\Models\User;

/**
 * The setup every new account needs, whichever door it came in through.
 *
 * It exists because the three doors had drifted apart, each doing a different
 * subset of the same job: Fortify's CreateNewUser handed out the role and a
 * team, SocialAuthController handed out a team and switched to it but no role,
 * and RegisterInvitedUser handed out neither. An invited account could not
 * create a campaign at all, since a campaign is created against its owner's
 * current team.
 *
 * Every step is conditional so that calling this twice, or calling it on an
 * account that a caller has already half prepared, changes nothing.
 */
class PrepareNewAccount
{
    public function __invoke(User $user): User
    {
        if (! $user->hasRole('standard')) {
            $user->assignRole('standard');
        }

        if ($user->ownedTeams()->doesntExist()) {
            $user->ownedTeams()->save(Team::forceCreate([
                'user_id' => $user->id,
                'name' => explode(' ', $user->name, 2)[0]."'s Team",
                'personal_team' => true,
            ]));
        }

        if ($user->current_team_id === null) {
            $user->switchTeam($user->ownedTeams()->first());
        }

        return $user;
    }
}
