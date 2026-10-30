<?php

use App\Models\User;
use Spatie\Health\Checks\Check;
use Spatie\Health\Facades\Health;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;
use VictoRD11\SslCertificationHealthCheck\SslCertificationValidCheck;
use VictoRD11\SslCertificationHealthCheck\SslCertificationExpiredCheck;

// The results page only reads what the last scheduled run stored, so none of
// these requests runs a check. That matters here: the SSL and security
// advisories checks would reach the network, which no test may do.

test('a guest is sent to the login page', function (): void {
    $this->get(route('admin.health'))->assertRedirect(route('login'));
});

test('a user without the admin role is refused', function (): void {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.health'))
        ->assertForbidden();
});

test('an admin sees the results page', function (): void {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.health'))
        ->assertOk();
});

test('the expected checks are registered', function (): void {
    $registered = Health::registeredChecks()
        ->map(fn (Check $check): string => $check::class)
        ->all();

    expect($registered)->toEqualCanonicalizing([
        EnvironmentCheck::class,
        DebugModeCheck::class,
        CpuLoadCheck::class,
        UsedDiskSpaceCheck::class,
        DatabaseCheck::class,
        ScheduleCheck::class,
        CacheCheck::class,
        RedisCheck::class,
        OptimizedAppCheck::class,
        SecurityAdvisoriesCheck::class,
        SslCertificationExpiredCheck::class,
        SslCertificationValidCheck::class,
    ]);
});

test('the heartbeat runs every minute and the checks every five', function (): void {
    $events = collect(app(Schedule::class)->events());

    $expressionFor = fn (string $command): ?string => $events
        ->first(fn (Event $event): bool => str_contains((string) $event->command, $command))
        ?->expression;

    expect($expressionFor('health:schedule-check-heartbeat'))->toBe('* * * * *')
        ->and($expressionFor('health:check'))->toBe('*/5 * * * *');
});
