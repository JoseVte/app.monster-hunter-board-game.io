<?php

use App\Models\User;
use Laravel\Dusk\Browser;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\DatabaseTruncation;

require_once __DIR__.'/helpers.php';

uses(Tests\DuskTestCase::class, DatabaseTruncation::class);

// DatabaseTruncation truncates every table between tests rather than
// re-migrating, which is what phpunit.dusk.xml's separate monster_hunter_dusk
// database is for. It does not reseed anything on its own, and
// PrepareNewAccount's assignRole('standard') needs the role to already exist,
// so it is seeded here rather than through a global hook the Feature suite
// would also pick up.
beforeEach(function (): void {
    $this->seed(RolesSeeder::class);
    resetServedAppCache();
});

test('login logout', function (): void {
    $user = duskUser();

    $this->browse(function (Browser $browser) use ($user): void {
        // The suite's own locale is English; forcing the browser's session to
        // match means asserting through __() proves something rather than
        // coincidentally matching whatever Accept-Language Chrome sent.
        $browser->visit('/language/en')
            ->clickLink(__('Log in'))
            ->waitFor('#email')
            ->type('#email', $user->email)
            ->type('#password', 'password')
            // PrimaryButton renders with the Tailwind `uppercase` utility, so
            // the text a real browser reports back is the upper-cased render,
            // not the string __() returns.
            ->press(mb_strtoupper(__('Log in')))
            ->waitForLocation(route('dashboard'))
            ->waitForText($user->name)
            ->assertSee($user->name)
            ->press('#profile-dropdown-btn')
            ->waitForText(__('Log Out'))
            ->press(__('Log Out'))
            ->waitForLocation('/')
            // Logging out invalidates the session, taking the locale forced
            // above with it. Without setting it again, this assertion depends
            // on Chrome's own Accept-Language, which is Spanish on the
            // machine this was written on and would otherwise fail here.
            ->visit('/language/en')
            ->assertSee(__('Log in'));
    });
});

test('register', function (): void {
    $this->browse(function (Browser $browser): void {
        $browser->visit('/language/en')
            ->clickLink(__('Register'))
            ->waitFor('#name')
            ->type('#name', 'Test Hunter')
            ->type('#email', 'test-hunter@example.test')
            ->type('#password', 'password')
            ->type('#password_confirmation', 'password')
            ->check('#terms')
            // Checked before submitting, so a failure here says the typing
            // never reached the form rather than surfacing later as "waited 5
            // seconds for a location". Both intermittent failures this was
            // added to diagnose have been found since: the verification
            // route's rate limit (`resetServedAppCache()`) and Chrome's
            // breached-password dialog swallowing input
            // (`DuskTestCase::driver()`). The check costs nothing to keep.
            ->assertInputValue('#name', 'Test Hunter')
            ->assertInputValue('#email', 'test-hunter@example.test')
            ->assertChecked('#terms')
            ->press(mb_strtoupper(__('Register')))
            // Features::emailVerification() is on, and `verified` guards both
            // /dashboard and profile.show, so registering lands here rather
            // than on the dashboard. No mailbox is wired up for this suite, so
            // this visits the same signed link the emailed notification would
            // carry instead of writing email_verified_at directly and skipping
            // a gate the app genuinely enforces.
            ->waitForLocation(route('verification.notice'));

        $user = User::where('email', 'test-hunter@example.test')->firstOrFail();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)],
        );

        $browser->visit($verificationUrl)
            ->waitForLocation(route('dashboard'))
            ->assertSee('Test Hunter')
            ->press('#profile-dropdown-btn')
            ->waitForText(__('Profile'))
            ->clickLink(__('Profile'))
            // DangerButton is uppercase too, and this label is reused for the
            // button that opens the confirmation dialog and the one inside it
            // that has the #delete-user-btn id; only the first needs pressing
            // by text.
            ->waitForText(mb_strtoupper(__('Delete Account')))
            ->press(mb_strtoupper(__('Delete Account')))
            ->waitFor('#delete-user-password')
            ->type('#delete-user-password', 'password')
            ->press('#delete-user-btn')
            ->waitForLocation('/')
            // Account deletion logs the session out too, taking the forced
            // locale with it; see the equivalent comment in the login test.
            ->visit('/language/en')
            ->assertSee(__('Log in'));

        // The account created above is the only one this test (or the
        // truncated database it runs against) has, and it was just deleted
        // through the whole DeleteUser chain.
        $this->assertDatabaseCount('users', 0);
    });
});
