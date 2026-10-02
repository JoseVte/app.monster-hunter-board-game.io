<?php

use App\Models\Campaign;
use Laravel\Dusk\Browser;
use App\Enum\MonsterExpansion;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;

require_once __DIR__.'/helpers.php';

uses(Tests\DuskTestCase::class, DatabaseTruncation::class);

/*
 * Creating a campaign in a real browser, against the real controller, request
 * and model, because the one bug this form has shipped lived in the seam none
 * of the suites below it could see: `Create.vue` never forwarded `baseMaxDays`,
 * so every create page read "Suggested: NaN days". It was found by hand. The
 * Vitest suites pin each piece now; this is the one test that watches the
 * whole chain at once, from the props `CampaignController::create()` sends to
 * the row `Campaign::booted()` saves.
 */
beforeEach(function (): void {
    $this->seed(RolesSeeder::class);
    resetServedAppCache();
});

function openCreateForm(Browser $browser): Browser
{
    // The suite asserts English strings, so the session's locale is forced to
    // match rather than left to whatever Accept-Language Chrome sends.
    return $browser->loginAs(duskUser())
        ->visit('/language/en')
        ->visit(route('campaigns.create'))
        ->waitFor('#max_days');
}

test('a new campaign works its timer out from the boxes ticked', function (): void {
    $this->browse(function (Browser $browser): void {
        openCreateForm($browser)
            // The Ancient Forest starts ticked, and adds nothing to the base 25.
            ->assertChecked('input[value="ANCIENT_FOREST"]')
            ->assertInputValue('#max_days', '25')
            ->assertSee('Suggested: 25 days')
            ->assertDontSee('NaN')
            ->check('input[value="PICKING_BONES"]')
            ->waitForText('Suggested: 40 days')
            ->assertInputValue('#max_days', '40')
            ->type('#name', 'Dusk campaign')
            ->press(mb_strtoupper(__('Create')))
            ->waitUsing(10, 100, fn (): bool => Campaign::where('name', 'Dusk campaign')->exists());
    });

    expect(Campaign::where('name', 'Dusk campaign')->sole())
        ->max_days->toBe(40)
        ->max_days_automatic->toBeTrue()
        ->expansions->toEqual([MonsterExpansion::ANCIENT_FOREST->name, MonsterExpansion::PICKING_BONES->name]);
});

test('a campaign with no base game is stopped before it is sent', function (): void {
    $this->browse(function (Browser $browser): void {
        openCreateForm($browser)
            ->uncheck('input[value="ANCIENT_FOREST"]')
            ->check('input[value="PICKING_BONES"]')
            ->type('#name', 'Boxless')
            ->press(mb_strtoupper(__('Create')))
            ->waitForText('Pick at least one of the base games.')
            ->assertRouteIs('campaigns.create');
    });

    expect(Campaign::where('name', 'Boxless')->exists())->toBeFalse();
});

test('a timer typed by hand is kept, with the suggestion still on screen', function (): void {
    $this->browse(function (Browser $browser): void {
        openCreateForm($browser)
            ->check('input[value="PICKING_BONES"]')
            ->waitForText('Suggested: 40 days')
            // The switch's own checkbox is visually hidden; a person clicks
            // its label, so the test does too.
            ->clickAtXPath("//label[contains(., 'Work the timer out from the expansions')]")
            ->waitUntilEnabled('#max_days')
            ->clear('#max_days')
            ->type('#max_days', '12')
            ->assertSee('Suggested: 40 days')
            ->type('#name', 'Hand timed')
            ->press(mb_strtoupper(__('Create')))
            ->waitUsing(10, 100, fn (): bool => Campaign::where('name', 'Hand timed')->exists());
    });

    expect(Campaign::where('name', 'Hand timed')->sole())
        ->max_days->toBe(12)
        ->max_days_automatic->toBeFalse();
});
