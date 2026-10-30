<?php

use App\Models\User;
use Illuminate\Support\Facades\URL;

// The suite asserts English strings, so the session's locale is forced to
// match rather than left to whatever Accept-Language the browser sends.
// Logging out or deleting the account invalidates the session and the locale
// with it, which is why the tests below set it again afterwards.

test('login logout', function (): void {
    $user = browserUser();

    visit('/language/en')
        ->click(__('Log in'))
        ->type('#email', $user->email)
        ->type('#password', 'password')
        ->press('form button[type="submit"]')
        ->assertRoute('dashboard')
        ->assertSee($user->name)
        ->press('#profile-dropdown-btn')
        ->press(__('Log Out'))
        ->assertPathIs('/')
        ->navigate('/language/en')
        ->assertSee(__('Log in'))
        ->assertNoJavaScriptErrors();
});

test('register', function (): void {
    $page = visit('/language/en')
        ->click(__('Register'))
        ->type('#name', 'Test Hunter')
        ->type('#email', 'test-hunter@example.test')
        ->type('#password', 'password')
        ->type('#password_confirmation', 'password')
        ->check('#terms')
        ->press('form button[type="submit"]')
        // Features::emailVerification() is on, and `verified` guards both
        // /dashboard and profile.show, so registering lands here rather than
        // on the dashboard. No mailbox is wired up, so the test visits the
        // same signed link the notification would carry instead of writing
        // email_verified_at directly and skipping a gate the app enforces.
        ->assertRoute('verification.notice');

    $user = User::where('email', 'test-hunter@example.test')->firstOrFail();

    // Generated after the first visit, once the plugin has pointed app.url at
    // the host the browser is on; the signature covers the host too.
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)],
    );

    $page->navigate($verificationUrl)
        ->assertRoute('dashboard')
        ->assertSee('Test Hunter')
        ->press('#profile-dropdown-btn')
        ->click(__('Profile'))
        // The label is also the section heading, and the #delete-user-btn
        // inside the dialog; until the dialog opens, this is the only button
        // carrying it.
        ->press('button:has-text("'.__('Delete Account').'")')
        ->type('#delete-user-password', 'password')
        ->press('#delete-user-btn')
        ->assertPathIs('/');

    // The browser is served from this process, so the container, and the
    // guards in it, outlive each request. `auth:sanctum` makes Sanctum's
    // request guard the default and that guard keeps the user it resolved,
    // which the web guard's logout above never touches: the deleted user
    // would stay "signed in" for the rest of the test. A real request starts
    // from a fresh container, which is what forgetting the guards stands for.
    auth()->forgetGuards();

    $page->navigate('/language/en')
        ->assertSee(__('Log in'));

    // The account created above was the only one, and it was just deleted
    // through the whole DeleteUser chain.
    $this->assertDatabaseCount('users', 0);
});
