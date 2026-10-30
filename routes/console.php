<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// The heartbeat is a cache write, so it can run every minute. The checks are
// not: the security advisories check asks Packagist, the SSL checks open a
// connection to the site and the disk check shells out to df, so they run
// every five minutes to keep the load down. ScheduleCheck's maximum age in
// HealthServiceProvider is sized against these two intervals.
Schedule::command(ScheduleCheckHeartbeatCommand::class)->everyMinute();

Schedule::command(RunHealthChecksCommand::class)
    ->everyFiveMinutes()
    ->withoutOverlapping();
