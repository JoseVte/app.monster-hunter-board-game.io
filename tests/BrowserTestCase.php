<?php

namespace Tests;

use Tighten\Ziggy\Ziggy;

/**
 * Base case for the Playwright suite in tests/Browser.
 *
 * The browser talks to the application inside this same process, served by
 * pest-plugin-browser, so the sqlite :memory: database, the array cache and
 * session, and any `Http::fake()` are shared with the test that drives it.
 */
abstract class BrowserTestCase extends TestCase
{
    /**
     * Registration is invitation only in production, and the Fortify feature
     * list (which decides whether the register route exists at all) is read
     * from the environment while the application boots. It has to be in place
     * before `parent::setUp()`, and it is taken away again afterwards so that
     * a Feature test running later in the same process sees the real default.
     */
    private const array ENVIRONMENT = ['AUTH_CAN_REGISTER' => 'true'];

    protected function setUp(): void
    {
        if (file_exists(dirname(__DIR__).'/public/hot')) {
            $this->markTestSkipped(
                'A Vite dev server is running (public/hot exists), so the browser suite would test the '
                .'dev bundle rather than the built one. Stop `npm run dev`, run `npm run build`, and try again.',
            );
        }

        foreach (self::ENVIRONMENT as $name => $value) {
            putenv("{$name}={$value}");
            $_ENV[$name] = $_SERVER[$name] = $value;
        }

        parent::setUp();

        // Ziggy keeps the route list in a static, so it outlives the
        // application of whichever test rendered a page first. A Feature test
        // earlier in the same process caches a list without `register`, the
        // Welcome page then asks route('register') for its link, Ziggy throws
        // in the browser and the page renders empty.
        Ziggy::clearRoutes();

        // TestCase stubs Vite out for the rest of the suite; here the page
        // needs the built assets, or it arrives with no JavaScript to drive.
        $this->withVite();

        // Google's published test site key: the real reCAPTCHA script loads
        // and hands out a token, and fakeRecaptcha() answers the server side.
        config(['services.google-recaptcha.site-key' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        foreach (array_keys(self::ENVIRONMENT) as $name) {
            putenv($name);
            unset($_ENV[$name], $_SERVER[$name]);
        }

        // And the other way round: the list cached here includes `register`.
        Ziggy::clearRoutes();
    }
}
