<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Fortify\Features;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testTwoFactorAuthenticationCanBeEnabled(): void
    {
        if (!Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two factor authentication is not enabled.');

            return;
        }

        $this->actingAs($user = User::factory()->create());

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $response = $this->post('/user/two-factor-authentication');

        $this->assertNotNull($user->fresh()->two_factor_secret);
        $this->assertCount(8, $user->fresh()->recoveryCodes());
    }

    public function testRecoveryCodesCanBeRegenerated(): void
    {
        if (!Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two factor authentication is not enabled.');

            return;
        }

        $this->actingAs($user = User::factory()->create());

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');
        $this->post('/user/two-factor-recovery-codes');

        $user = $user->fresh();

        $this->post('/user/two-factor-recovery-codes');

        $this->assertCount(8, $user->recoveryCodes());
        $this->assertCount(8, array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()));
    }

    public function testTwoFactorAuthenticationCanBeDisabled(): void
    {
        if (!Features::canManageTwoFactorAuthentication()) {
            $this->markTestSkipped('Two factor authentication is not enabled.');

            return;
        }

        $this->actingAs($user = User::factory()->create());

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');

        $this->assertNotNull($user->fresh()->two_factor_secret);

        $this->delete('/user/two-factor-authentication');

        $this->assertNull($user->fresh()->two_factor_secret);
    }
}
