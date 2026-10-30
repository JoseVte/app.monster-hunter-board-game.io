<?php

use Mockery as m;
use App\Models\User;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

// The provider round trip where it goes wrong, and the one path
// `SocialLoginTest` can only reach when the environment happens to open
// registration: a stranger arriving from a provider. Registration is opened
// here explicitly instead, so the path runs whatever `AUTH_CAN_REGISTER` says.

function socialiteReturns(string $provider, SocialiteUser $user): void
{
    $driver = m::mock('Laravel\Socialite\Two\GoogleProvider');
    $driver->allows('user')->andReturns($user);

    Socialite::shouldReceive('driver')->with($provider)->andReturn($driver);
}

function socialiteFails(string $provider, string $method): void
{
    $driver = m::mock('Laravel\Socialite\Two\GoogleProvider');
    $driver->allows($method)->andThrow(new RuntimeException('provider is down'));

    Socialite::shouldReceive('driver')->with($provider)->andReturn($driver);
}

function openRegistration(): void
{
    config(['fortify.features' => [...config('fortify.features'), Features::registration()]]);
}

test('a provider that cannot start the handshake sends the visitor back to log in', function (): void {
    socialiteFails('github', 'redirect');

    $this->get(route('auth.social.redirect', 'github'))
        ->assertRedirect(route('login'))
        ->assertSessionHas('error', __('Invalid credentials provided.'));
});

test('a failed callback lands on the login page for a visitor', function (): void {
    socialiteFails('discord', 'user');

    $this->get(route('auth.social.callback', 'discord'))
        ->assertRedirect(route('login'))
        ->assertSessionHas('error');

    $this->assertGuest();
});

test('a failed callback while linking goes back to the profile it started from', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $driver = m::mock('Laravel\Socialite\Two\GoogleProvider');
    $driver->allows('redirect')->andReturns(redirect('https://accounts.google.com'));
    $driver->allows('user')->andThrow(new RuntimeException('denied'));
    Socialite::shouldReceive('driver')->with('google')->andReturn($driver);

    $this->actingAs($user)
        ->get(route('profile.social.redirect', 'google'))
        ->assertRedirect('https://accounts.google.com');

    $this->get(route('auth.social.callback', 'google'))
        ->assertRedirect(route('profile.show'))
        ->assertSessionHas('error');

    expect($user->providers()->count())->toBe(0);
});

test('a stranger arriving from a provider gets a ready account when registration is open', function (): void {
    openRegistration();
    Event::fake([Registered::class]);

    socialiteReturns('github', (new SocialiteUser)
        ->map(['id' => '42', 'nickname' => 'palico', 'name' => null, 'email' => 'palico@example.com', 'avatar' => 'https://example.com/a.png'])
        ->setToken('token')
        ->setRefreshToken('refresh')
        ->setExpiresIn(60));

    $this->freezeTime();

    $this->get(route('auth.social.callback', 'github'))
        ->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('email', 'palico@example.com')->firstOrFail();
    $provider = $user->providers()->firstOrFail();

    $this->assertAuthenticatedAs($user);
    // No real name on the provider, so the nickname stands in for it.
    expect($user->name)->toBe('palico')
        ->and($user->hasVerifiedEmail())->toBeTrue()
        ->and($user->personalTeam())->not->toBeNull()
        ->and($user->hasRole('standard'))->toBeTrue()
        ->and($provider->provider)->toBe('github')
        ->and($provider->provider_id)->toBe('42')
        ->and($provider->avatar_path)->toBe('https://example.com/a.png')
        ->and($provider->refresh_token)->toBe('refresh')
        ->and($provider->expires_at->toDateTimeString())->toBe(now()->addSeconds(60)->toDateTimeString());

    Event::assertDispatched(Registered::class, fn (Registered $event): bool => $event->user->is($user));
});

test('a provider without an expiry stores none', function (): void {
    openRegistration();

    socialiteReturns('google', (new SocialiteUser)
        ->map(['id' => '7', 'nickname' => null, 'name' => 'Ada', 'email' => 'ada@example.com', 'avatar' => null])
        ->setToken('token'));

    $this->get(route('auth.social.callback', 'google'));

    $provider = User::where('email', 'ada@example.com')->firstOrFail()->providers()->firstOrFail();

    expect($provider->expires_at)->toBeNull()
        ->and($provider->refresh_token)->toBeNull();
});

test('unlinking only removes the provider named', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $user->providers()->create(['provider' => 'google', 'provider_id' => 'g', 'token' => 't']);
    $user->providers()->create(['provider' => 'discord', 'provider_id' => 'd', 'token' => 't']);

    $this->actingAs($user)
        ->delete(route('profile.social.unlink', 'google'))
        ->assertStatus(303);

    expect($user->providers()->pluck('provider')->all())->toBe(['discord']);
});
