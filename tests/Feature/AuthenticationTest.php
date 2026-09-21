<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

// `captcha_token` is now `required`, so a login that omits it is rejected
// before the credentials are looked at. It used to be skipped when absent,
// which is what let these tests pass without ever mentioning it. The token
// itself can be anything: tests/Pest.php fakes siteverify into a passing score.

test('login screen can be rendered', function (): void {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function (): void {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'captcha_token' => 'a-token',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can not authenticate with invalid password', function (): void {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'captcha_token' => 'a-token',
    ]);

    $this->assertGuest();
});

// The check must not be skippable by leaving the field out, which is exactly
// what happened before it was marked required.
test('a login without a captcha token is refused', function (): void {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertGuest();
});
