<?php

use App\Models\Campaign;
use App\Enum\MonsterExpansion;

/*
 * Creating a campaign in a real browser, against the real controller, request
 * and model, because the one bug this form has shipped lived in the seam none
 * of the suites below it could see: `Create.vue` never forwarded `baseMaxDays`,
 * so every create page read "Suggested: NaN days". It was found by hand. The
 * Vitest suites pin each piece now; this is the one test that watches the
 * whole chain at once, from the props `CampaignController::create()` sends to
 * the row `Campaign::booted()` saves.
 */

function openCreateForm(): mixed
{
    test()->actingAs(browserUser());

    // The suite asserts English strings, so the session's locale is forced to
    // match rather than left to whatever Accept-Language the browser sends.
    return visit('/language/en')
        ->navigate(route('campaigns.create', absolute: false))
        ->assertPresent('#max_days');
}

test('a new campaign works its timer out from the boxes ticked', function (): void {
    openCreateForm()
        // The Ancient Forest starts ticked, and adds nothing to the base 25.
        ->assertChecked('input[value="ANCIENT_FOREST"]')
        ->assertValue('#max_days', '25')
        ->assertSee('Suggested: 25 days')
        ->assertDontSee('NaN')
        ->check('input[value="PICKING_BONES"]')
        ->assertSee('Suggested: 40 days')
        ->assertValue('#max_days', '40')
        ->type('#name', 'Browser campaign')
        ->press(__('Create'))
        ->assertPathIs('/campaigns/*/edit')
        ->assertNoJavaScriptErrors();

    expect(Campaign::where('name', 'Browser campaign')->sole())
        ->max_days->toBe(40)
        ->max_days_automatic->toBeTrue()
        ->expansions->toEqual([MonsterExpansion::ANCIENT_FOREST->name, MonsterExpansion::PICKING_BONES->name]);
});

test('a campaign with no base game is stopped before it is sent', function (): void {
    openCreateForm()
        ->uncheck('input[value="ANCIENT_FOREST"]')
        ->check('input[value="PICKING_BONES"]')
        ->type('#name', 'Boxless')
        ->press(__('Create'))
        ->assertSee('Pick at least one of the base games.')
        ->assertRoute('campaigns.create');

    expect(Campaign::where('name', 'Boxless')->exists())->toBeFalse();
});

test('a timer typed by hand is kept, with the suggestion still on screen', function (): void {
    openCreateForm()
        ->check('input[value="PICKING_BONES"]')
        ->assertSee('Suggested: 40 days')
        // The switch's own checkbox is visually hidden; a person clicks its
        // label, so the test does too.
        ->click('label:has-text("Work the timer out from the expansions")')
        ->assertEnabled('#max_days')
        ->clear('#max_days')
        ->type('#max_days', '12')
        ->assertSee('Suggested: 40 days')
        ->type('#name', 'Hand timed')
        ->press(__('Create'))
        ->assertPathIs('/campaigns/*/edit');

    expect(Campaign::where('name', 'Hand timed')->sole())
        ->max_days->toBe(12)
        ->max_days_automatic->toBeFalse();
});
