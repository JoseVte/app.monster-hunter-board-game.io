<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invitation;

class InvitationPolicy
{
    /**
     * Revoking and resending both rewrite the invitation, so both answer to
     * this. Only the person who sent it may touch it.
     */
    public function update(User $user, Invitation $invitation): bool
    {
        return $invitation->inviter_id === $user->id;
    }
}
