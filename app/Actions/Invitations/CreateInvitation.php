<?php

namespace App\Actions\Invitations;

use App\Models\User;
use App\Models\Invitation;

class CreateInvitation
{
    /**
     * The raw token is returned rather than stored, so callers can put it in an
     * email or show it once. It cannot be recovered afterwards.
     *
     * A null inviter means the console issued it. That is how the first account
     * on an empty database gets in: an invitation needs a user, and until
     * somebody accepts one there is no user to be it.
     *
     * @return array{invitation: Invitation, token: string}
     */
    public function __invoke(?User $inviter, ?string $email = null): array
    {
        $token = Invitation::newToken();

        $invitation = Invitation::create([
            'inviter_id' => $inviter?->id,
            'email' => $email,
            'token' => Invitation::hashToken($token),
            'expires_at' => now()->addDays(config('invitations.expires_after_days')),
        ]);

        return ['invitation' => $invitation, 'token' => $token];
    }
}
