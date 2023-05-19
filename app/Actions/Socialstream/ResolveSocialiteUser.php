<?php

namespace App\Actions\Socialstream;

use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;
use JoelButcher\Socialstream\Socialstream;
use JoelButcher\Socialstream\Contracts\ResolvesSocialiteUsers;

class ResolveSocialiteUser implements ResolvesSocialiteUsers
{
    /**
     * Resolve the user for a given provider.
     */
    public function resolve(string $provider): User
    {
        $user = Socialite::driver($provider)->user();

        if (Socialstream::generatesMissingEmails()) {
            $user->email = $user->getEmail() ?? ("{$user->id}@{$provider}".config('app.domain'));
        }

        return $user;
    }
}
