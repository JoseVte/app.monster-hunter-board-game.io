<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)
    /*
    |--------------------------------------------------------------------------
    | Outgoing HTTP
    |--------------------------------------------------------------------------
    |
    | No test may reach the network. The captcha rule posts a token to Google to
    | verify it, so any test that sends `captcha_token` would call siteverify for
    | real, from CI, with whatever secret the environment happens to hold.
    | preventStrayRequests turns a request this does not fake into a failure
    | rather than a silent call, which is how it was found: the first version of
    | this hook was chained wrong, did not apply, and a test came back with a
    | genuine `invalid-input-response` from Google.
    |
    | The default answer is a pass. A test that wants the captcha to reject fakes
    | a low score itself.
    |
    */
    ->beforeEach(fn () => fakeRecaptcha())
    ->in('Feature');

// The browser suite is served from this same process, so the fake below
// answers the siteverify call the login and register forms trigger as well.
uses(Tests\BrowserTestCase::class, RefreshDatabase::class)
    ->beforeEach(fn () => fakeRecaptcha())
    ->in('Browser');

/*
|--------------------------------------------------------------------------
| Outgoing HTTP
|--------------------------------------------------------------------------
|
| No test may reach the network. The captcha rule posts to Google to verify a
| token, so the moment a test sends `captcha_token` the suite would start
| calling siteverify for real, from CI, with whatever secret the environment
| happens to hold. preventStrayRequests turns any request this does not fake
| into a failure rather than a silent call.
|
| The default answer is a pass. A test that wants the captcha to reject says so
| itself by faking a low score.
|
*/

beforeEach(function (): void {
    Http::preventStrayRequests();

    Http::fake([
        'www.google.com/recaptcha/*' => Http::response([
            'success' => true,
            'score' => 0.9,
            'action' => 'test',
        ]),
    ]);
})->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something(): void
{
    // ..
}

/**
 * A user who can actually use the app, for the browser suite.
 *
 * Every registration path goes through PrepareNewAccount: it grants the
 * standard role and a personal team, and campaigns.store requires a team_id
 * that exists and belongs to the caller. A user built without it would fail
 * somewhere unhelpful.
 */
function browserUser(): App\Models\User
{
    $user = App\Models\User::factory()->create([
        'name' => 'Test Hunter',
        'password' => Illuminate\Support\Facades\Hash::make('password'),
    ]);

    app(App\Actions\PrepareNewAccount::class)($user);

    return $user;
}

/**
 * Answer Google's siteverify with the given payload, and refuse every other
 * outgoing request.
 *
 * It replaces the client rather than adding a stub, because `Http::fake()`
 * accumulates and the *first* registered stub wins. Layering a second call on
 * top of the one every test starts with does nothing, which is how two tests
 * here came to assert a rejection and quietly get the default pass instead.
 */
function fakeRecaptcha(array $payload = ['success' => true, 'score' => 0.9, 'action' => 'test']): void
{
    Http::swap(new Illuminate\Http\Client\Factory);

    Http::fake(['www.google.com/recaptcha/*' => Http::response($payload)]);

    Http::preventStrayRequests();
}
