<?php

namespace Tests;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use PHPUnit\Framework\Attributes\BeforeClass;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * This file had drifted from the stub Dusk 8 actually ships (compare
     * vendor/laravel/dusk/stubs/DuskTestCase.stub): the doc-comment
     * `@beforeClass` annotation this used to carry is never read by PHPUnit
     * 10+, which only parses the `#[BeforeClass]` attribute for this hook.
     * With the annotation, `prepare()` silently never ran, chromedriver never
     * started, and every browser test failed to connect to localhost:9515
     * before a single assertion.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        // Whatever an earlier run left behind, including one that was killed
        // or crashed before it could clean up after itself.
        static::discardChromeProfiles();

        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }

        // Registered after `startChromeDriver()`, so it runs after the
        // callback that stops chromedriver: the browser has been quit and the
        // driver is gone by the time the profile is deleted. Dusk never clears
        // these callbacks, so from the second class on it runs more than once,
        // which deleting a directory that is already gone does not mind.
        static::afterClass(fn () => static::discardChromeProfiles());
    }

    /**
     * Where each browser session keeps its Chrome profile.
     *
     * Left to itself, chromedriver puts every profile in a fresh
     * `org.chromium.Chromium.scoped_dir.*` under the system temp directory and
     * deletes it once Chrome has exited. Dusk stops chromedriver the moment it
     * has quit the browser, so the deletion never happened: every session left
     * its profile behind, 100 to 140 MB each. A day of running this suite
     * leaked 197 of them, 5 GB, and the disk filling up took MySQL down
     * mid-migration and left Herd's PHP serving a fatal error until it was
     * restarted. Before anyone knew that, it looked like `AuthTest` failing
     * one run in five for no reason.
     *
     * Naming the profile directory ourselves means it is ours to delete.
     */
    protected static function chromeProfilesPath(): string
    {
        return sys_get_temp_dir().DIRECTORY_SEPARATOR.'monster-hunter-dusk-chrome';
    }

    // `Filesystem` rather than the `File` facade: this runs in
    // `#[BeforeClass]`, before any application exists to resolve a facade
    // from.
    protected static function discardChromeProfiles(): void
    {
        (new Filesystem)->deleteDirectory(static::chromeProfilesPath());
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            // One profile per session, under a directory `discardChromeProfiles()`
            // empties; see `chromeProfilesPath()` for why it is not left to
            // chromedriver.
            // The breach check itself, in case the prefs below leave it on.
            '--disable-features=PasswordLeakDetection',
            '--user-data-dir='.static::chromeProfilesPath().DIRECTORY_SEPARATOR.uniqid('profile-', true),
        ])->unless($this->hasHeadlessDisabled(), fn (Collection $items) => $items->merge([
            '--disable-gpu',
            '--headless=new', // Disable with magic
        ]))->all());

        // Chrome's password manager, off. After a form submits a password it
        // checks it against Google's breach list, and `AuthTest` logs in and
        // registers with `password`, which is on it. The answer arrives a
        // second or so later as a browser dialog ("Change your password") that
        // takes the input for itself: the page underneath stays visible and
        // scriptable, `elementFromPoint` still finds the button, and every
        // click and keystroke WebDriver sends from then on is reported as sent
        // and never reaches the document, for the rest of that browser
        // session. Whether the test had already finished its clicks by the
        // time the dialog opened was a race, which is why `AuthTest` failed
        // about one full run in seven and `CampaignTest`, which logs in with
        // `loginAs()` and never types a password, never did. A probe that
        // logged in and out ten times per browser failed in most rounds before
        // this and passed 80 cycles out of 80 after it.
        $options->setExperimentalOption('prefs', [
            'credentials_enable_service' => false,
            'profile.password_manager_enabled' => false,
            'profile.password_manager_leak_detection' => false,
        ]);

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     */
    protected function hasHeadlessDisabled(): bool
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED'])
               || isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }

    /**
     * Determine if the browser window should start maximized.
     */
    protected function shouldStartMaximized(): bool
    {
        return isset($_SERVER['DUSK_START_MAXIMIZED'])
               || isset($_ENV['DUSK_START_MAXIMIZED']);
    }
}
