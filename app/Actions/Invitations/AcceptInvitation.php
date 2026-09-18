<?php

namespace App\Actions\Invitations;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InvitationNoLongerPendingException;

class AcceptInvitation
{
    public function __construct(private RegisterInvitedUser $registerInvitedUser) {}

    /**
     * Shared by the registration form and the social callback so the two paths
     * cannot drift apart.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __invoke(Invitation $invitation, array $attributes, bool $emailIsTrusted): User
    {
        return DB::transaction(function () use ($invitation, $attributes, $emailIsTrusted): User {
            $user = ($this->registerInvitedUser)($attributes, $emailIsTrusted);

            $this->markAccepted($invitation, $user);

            return $user;
        });
    }

    /**
     * The invitation is re-read locked and re-checked here rather than in the
     * caller, so two near simultaneous acceptances of one link cannot both
     * succeed no matter which caller forgets to check. Callers are expected to
     * run this inside their own transaction, so a refusal rolls back the user
     * they had already created.
     *
     * @throws InvitationNoLongerPendingException
     */
    public function markAccepted(Invitation $invitation, User $user): void
    {
        $current = Invitation::whereKey($invitation->getKey())->lockForUpdate()->first();

        if ($current === null || ! $current->isPending()) {
            throw new InvitationNoLongerPendingException;
        }

        $current->forceFill([
            'accepted_at' => now(),
            'accepted_by_id' => $user->id,
        ])->save();
    }
}
