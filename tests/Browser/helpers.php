<?php

use App\Models\User;
use App\Actions\PrepareNewAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

/*
 * Helpers shared by the browser tests, required by each file that needs them
 * rather than put in `tests/Pest.php`, which the Feature suite loads too.
 */

// Every registration path goes through PrepareNewAccount: it grants the
// standard role and a personal team, and campaigns.store requires a team_id
// that exists and belongs to the caller. A user built without it cannot use
// the app and the test would fail somewhere unhelpful.
function duskUser(): User
{
    $user = User::factory()->create(['name' => 'Test Hunter', 'password' => Hash::make('password')]);

    app(PrepareNewAccount::class)($user);

    return $user;
}

// Wipe the rate limiter state the served application keeps between tests.
//
// The browser talks to a separate application, served by Herd or `artisan
// serve`, whose cache is the file store `.env.dusk` names, while this process
// runs on the array store `phpunit.dusk.xml` sets, so `Cache::flush()` here
// would clear the wrong one. That file store outlives every test and every
// run, and `DatabaseTruncation` hands the same user ids out again each time,
// so the email verification route's `throttle:6,1` counted every run's user
// as one: a seventh `php artisan dusk` inside a minute failed `register` with
// nothing but "waited 5 seconds for location". It took a run of eight
// back-to-back registrations, the seventh and eighth failing, to see it. It
// can never happen in CI, which runs the suite once.
//
// This clears the local development cache too, since both environments share
// `storage/framework/cache`; nothing there is worth more than a flaky suite.
function resetServedAppCache(): void
{
    Artisan::call('cache:clear', ['store' => 'file']);
}
