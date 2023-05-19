<?php

namespace App\Actions\Socialstream;

use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JoelButcher\Socialstream\Contracts\GeneratesProviderRedirect;

class GenerateRedirectForProvider implements GeneratesProviderRedirect
{
    /**
     * Generates the redirect for a given provider.
     */
    public function generate(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }
}
