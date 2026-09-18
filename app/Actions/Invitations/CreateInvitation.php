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
     * @return array{invitation: Invitation, token: string}
     */
    public function __invoke(User $inviter, ?string $email = null): array
    {
        $token = Invitation::newToken();

        $invitation = Invitation::create([
            'inviter_id' => $inviter->id,
            'email' => $email,
            'token' => Invitation::hashToken($token),
            'expires_at' => now()->addDays(config('invitations.expires_after_days')),
        ]);

        return ['invitation' => $invitation, 'token' => $token];
    }
}
