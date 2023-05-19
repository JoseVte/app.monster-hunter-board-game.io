<?php

namespace Tests\Feature;

use Mockery as m;
use Tests\TestCase;
use Laravel\Socialite\Two\User;
use App\Providers\RouteServiceProvider;
use JoelButcher\Socialstream\Providers;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Fortify\Features as FortifyFeatures;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialstreamRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider socialiteProvidersDataProvider
     */
    public function testUsersCanRegisterUsingSocialiteProviders(string $socialiteProvider)
    {
        if (!FortifyFeatures::enabled(FortifyFeatures::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        if (!Providers::enabled($socialiteProvider)) {
            return $this->markTestSkipped("Registration support with the $socialiteProvider provider is not enabled.");
        }

        $user = (new User())
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
        $provider->shouldReceive('user')->once()->andReturn($user);

        Socialite::shouldReceive('driver')->once()->with($socialiteProvider)->andReturn($provider);

        session()->put('socialstream.previous_url', route('register'));

        $response = $this->get("/oauth/$socialiteProvider/callback");

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function socialiteProvidersDataProvider(): array
    {
        return [
            [Providers::google()],
            [Providers::facebook()],
            [Providers::linkedin()],
            [Providers::bitbucket()],
            [Providers::github()],
            [Providers::gitlab()],
            [Providers::twitter()],
        ];
    }
}
