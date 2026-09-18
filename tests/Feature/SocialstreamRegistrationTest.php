<?php

use Mockery as m;
use Laravel\Socialite\Two\User;
use App\Providers\RouteServiceProvider;
use JoelButcher\Socialstream\Providers;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Fortify\Features as FortifyFeatures;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users can register using socialite providers', function (string $socialiteProvider): void {
    if (! FortifyFeatures::enabled(FortifyFeatures::registration())) {
        $this->markTestSkipped('Registration support is not enabled.');

        return;
    }

    if (! Providers::enabled($socialiteProvider)) {
        $this->markTestSkipped("Registration support with the $socialiteProvider provider is not enabled.");

        return;
    }

    $user = (new User)
        ->map([
            'id' => 'abcdefgh',
            'nickname' => 'Jane',
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'avatar' => null,
            'avatar_original' => null,
        ])
        ->setToken('user-token')
        ->setRefreshToken('refresh-token')
        ->setExpiresIn(3600);

    $provider = m::mock('Laravel\\Socialite\\Two\\'.$socialiteProvider.'Provider');
    $provider->expects('user')->andReturns($user);

    Socialite::shouldReceive('driver')->once()->with($socialiteProvider)->andReturn($provider);

    session()->put('socialstream.previous_url', route('register'));

    $response = $this->get("/oauth/$socialiteProvider/callback");

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
})->with('socialiteProvidersDataProvider');

/*
 * @return array<int, array<int, string>>
 */
dataset('socialiteProvidersDataProvider', fn () => [
    [Providers::google()],
    [Providers::facebook()],
    [Providers::linkedin()],
    [Providers::bitbucket()],
    [Providers::github()],
    [Providers::gitlab()],
    [Providers::twitter()],
]);
