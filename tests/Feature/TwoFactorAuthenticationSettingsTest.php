<?php

use App\Models\User;
use Laravel\Fortify\Features;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('two factor authentication can be enabled', function (): void {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two factor authentication is not enabled.');

        return;
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $response = $this->post('/user/two-factor-authentication');

    expect($user->fresh()->two_factor_secret)->not->toBeNull()
        ->and($user->fresh()->recoveryCodes())->toHaveCount(8);
});

test('recovery codes can be regenerated', function (): void {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two factor authentication is not enabled.');

        return;
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post('/user/two-factor-authentication');
    $this->post('/user/two-factor-recovery-codes');

    $user = $user->fresh();

    $this->post('/user/two-factor-recovery-codes');

    expect($user->recoveryCodes())->toHaveCount(8)
        ->and(array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()))->toHaveCount(8);
});

test('two factor authentication can be disabled', function (): void {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two factor authentication is not enabled.');

        return;
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post('/user/two-factor-authentication');

    expect($user->fresh()->two_factor_secret)->not->toBeNull();

    $this->delete('/user/two-factor-authentication');

    expect($user->fresh()->two_factor_secret)->toBeNull();
});
