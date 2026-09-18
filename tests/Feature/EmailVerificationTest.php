<?php

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

test('the user model is one the framework will ask to verify', function (): void {
    expect(User::factory()->create())->toBeInstanceOf(Illuminate\Contracts\Auth\MustVerifyEmail::class);
});

test('registering sends the verification notification', function (): void {
    Notification::fake();

    event(new Illuminate\Auth\Events\Registered($user = User::factory()->unverified()->create()));

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('an unverified user is turned away from a protected page', function (): void {
    $user = User::factory()->unverified()->withPersonalTeam()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('verification.notice'));
});

test('a verified user reaches the same page', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk();
});

test('the signed link marks the address verified', function (): void {
    Event::fake([Verified::class]);

    $user = User::factory()->unverified()->withPersonalTeam()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $this->actingAs($user)->get($url);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});
