<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
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
    }
}
