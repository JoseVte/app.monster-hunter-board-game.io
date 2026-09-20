<?php

namespace App\Actions\Invitations;

use App\Models\User;
use App\Actions\PrepareNewAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

/**
 * Creating an account from an invitation, shared by the platform invitation and
 * the campaign one so the two cannot drift apart on the part that matters: who
 * gets a verification email.
 */
class RegisterInvitedUser
{
    public function __construct(private PrepareNewAccount $prepareNewAccount) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __invoke(array $attributes, bool $emailIsTrusted): User
    {
        $user = ($this->prepareNewAccount)(User::create($attributes));

        if ($emailIsTrusted) {
            $user->forceFill(['email_verified_at' => now()])->save();

            return $user;
        }

        // Only the untrusted path needs the event: its listener sends the
        // verification email, which would be noise for an address a provider
        // just vouched for. Deferred past the commit so a mail transport that
        // hangs cannot roll back the account it was meant to welcome.
        DB::afterCommit(fn () => event(new Registered($user)));

        return $user;
    }
}
