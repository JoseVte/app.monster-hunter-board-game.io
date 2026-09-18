<?php

use Mockery as m;
use App\Models\User;
use App\Models\Provider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Laravel\Fortify\Features as FortifyFeatures;
use Laravel\Socialite\Two\User as SocialiteUser;

function fakeProviderUser(string $provider, string $email = 'janedoe@example.com', string $id = 'abcdefgh'): void
{
    $socialiteUser = (new SocialiteUser)
        ->map([
            'id' => $id,
            'nickname' => 'Jane',
            'name' => 'Jane Doe',
            'email' => $email,
            'avatar' => null,
        ])
        ->setToken('user-token')
        ->setRefreshToken('refresh-token')
        ->setExpiresIn(3600);

    $driver = m::mock('Laravel\Socialite\Two\GoogleProvider');
    $driver->allows('user')->andReturns($socialiteUser);

    Socialite::shouldReceive('driver')->with($provider)->andReturn($driver);
}

test('the redirect hands off to socialite', function (): void {
    $driver = m::mock('Laravel\Socialite\Two\GoogleProvider');
    $driver->expects('redirect')->andReturns(redirect('https://accounts.google.com'));
    Socialite::shouldReceive('driver')->with('google')->andReturn($driver);

    $response = $this->get(route('auth.social.redirect', 'google'));

    $response->assertRedirect('https://accounts.google.com');
});

test('an unknown provider is rejected by the route', function (): void {
    $response = $this->get('/auth/myspace');

    $response->assertStatus(404);
});

test('a new user is registered from the provider', function (): void {
    if (! FortifyFeatures::enabled(FortifyFeatures::registration())) {
        $this->markTestSkipped('Registration support is not enabled.');
    }

    fakeProviderUser('google');

    $response = $this->get(route('auth.social.callback', 'google'));

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('email', 'janedoe@example.com')->firstOrFail();
    expect($user->name)->toEqual('Jane Doe')
        ->and($user->hasVerifiedEmail())->toBeTrue()
        ->and($user->ownedTeams()->count())->toEqual(1)
        ->and($user->providers()->where('provider', 'google')->count())->toEqual(1);
});

test('an existing user signs in instead of being duplicated', function (): void {
    $existing = User::factory()->withPersonalTeam()->create(['email' => 'janedoe@example.com']);

    fakeProviderUser('google');

    $response = $this->get(route('auth.social.callback', 'google'));

    $this->assertAuthenticatedAs($existing);
    expect(User::where('email', 'janedoe@example.com')->count())->toEqual(1)
        ->and($existing->providers()->count())->toEqual(1);
});

test('signing in twice does not duplicate the provider row', function (): void {
    User::factory()->withPersonalTeam()->create(['email' => 'janedoe@example.com']);

    fakeProviderUser('google');
    $this->get(route('auth.social.callback', 'google'));

    fakeProviderUser('google');
    $this->get(route('auth.social.callback', 'google'));

    expect(Provider::where('provider', 'google')->count())->toEqual(1);
});

test('an authenticated user links the account instead of signing in again', function (): void {
    $user = User::factory()->withPersonalTeam()->create(['email' => 'someone@example.com']);
    $this->actingAs($user);

    fakeProviderUser('google', 'janedoe@example.com');

    $response = $this->get(route('auth.social.callback', 'google'));

    $response->assertRedirect(route('profile.show'));
    expect($user->providers()->where('provider', 'google')->count())->toEqual(1)
        ->and(User::where('email', 'janedoe@example.com')->exists())->toBeFalse();
});

test('linking an account already owned by someone else is refused', function (): void {
    $owner = User::factory()->withPersonalTeam()->create();
    $owner->providers()->create([
        'provider' => 'google',
        'provider_id' => 'abcdefgh',
        'token' => 'token',
    ]);

    $user = User::factory()->withPersonalTeam()->create();
    $this->actingAs($user);

    fakeProviderUser('google');

    $response = $this->get(route('auth.social.callback', 'google'));

    $response->assertRedirect(route('profile.show'));
    $response->assertSessionHas('error');
    expect($user->providers()->count())->toEqual(0)
        ->and($owner->providers()->count())->toEqual(1);
});

test('a linked account can be unlinked', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $user->providers()->create([
        'provider' => 'google',
        'provider_id' => 'abcdefgh',
        'token' => 'token',
    ]);
    $this->actingAs($user);

    $response = $this->delete(route('profile.social.unlink', 'google'));

    $response->assertStatus(303);
    expect($user->providers()->count())->toEqual(0);
});

test('unlinking requires authentication', function (): void {
    $response = $this->delete(route('profile.social.unlink', 'google'));

    $response->assertRedirect(route('login'));
});

test('signing in through a provider needs no verification email', function (): void {
    if (! FortifyFeatures::enabled(FortifyFeatures::registration())) {
        $this->markTestSkipped('Registration support is not enabled.');
    }

    Notification::fake();

    fakeProviderUser('google');

    $this->get(route('auth.social.callback', 'google'));

    $user = User::where('email', 'janedoe@example.com')->firstOrFail();

    expect($user->hasVerifiedEmail())->toBeTrue();
    Notification::assertNotSentTo($user, VerifyEmail::class);
});

test('a provider cannot create an account while registration is closed', function (): void {
    if (FortifyFeatures::enabled(FortifyFeatures::registration())) {
        $this->markTestSkipped('Registration is open, so a provider may create accounts.');
    }

    fakeProviderUser('google');

    $this->get(route('auth.social.callback', 'google'));

    expect(User::where('email', 'janedoe@example.com')->exists())->toBeFalse();
    $this->assertGuest();
});
