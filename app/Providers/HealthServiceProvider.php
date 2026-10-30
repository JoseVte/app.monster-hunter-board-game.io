<?php

namespace App\Providers;

use Spatie\Health\Facades\Health;
use Illuminate\Support\ServiceProvider;
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

class HealthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Health::checks([
            EnvironmentCheck::new(),
            DebugModeCheck::new(),
            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(15)
                ->failWhenLoadIsHigherInTheLast15Minutes(15),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
            DatabaseCheck::new(),
            // The heartbeat is written every minute and the checks run every
            // five (routes/console.php). Ten minutes is two check runs, so a
            // deploy or one slow tick does not raise an alert. The checks are
            // run by the same scheduler, so a scheduler that stops altogether
            // stops them too and sends nothing: only opening the results page
            // with `?fresh` shows it.
            ScheduleCheck::new()->heartbeatMaxAgeInMinutes(10),
            CacheCheck::new(),
            RedisCheck::new(),
            OptimizedAppCheck::new()
                ->checkConfig()
                ->checkRoutes(),
            SecurityAdvisoriesCheck::new(),
            SslCertificationExpiredCheck::new()
                ->url(config('app.url'))
                ->warnWhenSslCertificationExpiringDay(15)
                ->failWhenSslCertificationExpiringDay(10),
            SslCertificationValidCheck::new()->url(config('app.url')),
        ]);
    }
}
