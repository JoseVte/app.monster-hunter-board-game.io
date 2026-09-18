<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Http\Requests\LoginRequest;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\GitHub\Provider as GitHubProvider;
use SocialiteProviders\Google\Provider as GoogleProvider;
use SocialiteProviders\Discord\Provider as DiscordProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(LoginRequest::class, \App\Http\Requests\LoginRequest::class);

        // Listeners in app/Listeners are discovered by the framework. These are
        // vendor classes, so they still have to be wired up by hand.
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('google', GoogleProvider::class);
            $event->extendSocialite('github', GitHubProvider::class);
            $event->extendSocialite('discord', DiscordProvider::class);
        });

        $this->dropDuplicateListeners();
    }

    /**
     * `cjmellor/level-up` registers its listeners through a provider that extends
     * Laravel's `Foundation\Support\Providers\EventServiceProvider`. That parent
     * wires up `SendEmailVerificationNotification` in `booted()` unless its own
     * `$listen` names it, which the package's does not. The framework has already
     * registered it, so registration ends up firing it twice and every new account
     * receives two verification emails.
     *
     * This runs after every provider has booted and collapses the duplicates,
     * preserving order. Remove it if level-up stops extending that class.
     */
    private function dropDuplicateListeners(): void
    {
        $this->app->booted(function (): void {
            $listeners = array_values(array_unique(
                Event::getRawListeners()[Registered::class] ?? [],
                SORT_REGULAR
            ));

            Event::forget(Registered::class);

            foreach ($listeners as $listener) {
                Event::listen(Registered::class, $listener);
            }
        });
    }
}
