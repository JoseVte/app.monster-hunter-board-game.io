<?php

use App\Models\User;
use App\Models\Campaign;
use App\Enum\MonsterExpansion;

/**
 * A campaign's timer is either worked out from the expansions in play or typed
 * by hand, and `max_days_automatic` is which. The invariant that matters is
 * that the two can never disagree: a campaign marked automatic cannot be
 * holding a number nobody would arrive at from its expansions.
 */
beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
});

test('the base campaign is 25 days with nothing added', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => [],
    ]);

    expect($campaign->suggestedMaxDays())->toEqual(25)
        ->and(Campaign::BASE_MAX_DAYS)->toEqual(25);
});

test('an expansion lengthens the suggestion by what it declares', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => [MonsterExpansion::PICKING_BONES->name],
    ]);

    expect(MonsterExpansion::PICKING_BONES->extraCampaignDays())->toEqual(15)
        ->and($campaign->suggestedMaxDays())->toEqual(40);
});

test('an expansion the enum no longer declares is ignored rather than fatal', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => ['PICKING_BONES', 'A_BOX_THAT_WAS_RENAMED'],
    ]);

    expect($campaign->expansionCases())->toHaveCount(1)
        ->and($campaign->suggestedMaxDays())->toEqual(40);
});

test('saving an automatic campaign overwrites whatever timer it was handed', function (): void {
    // Not through the form: the point is that the invariant holds from any
    // path, including a factory, a seeder or a console command.
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => [MonsterExpansion::PICKING_BONES->name],
        'max_days_automatic' => true,
        'max_days' => 999,
    ]);

    expect($campaign->max_days)->toEqual(40);

    $campaign->update(['expansions' => []]);

    expect($campaign->refresh()->max_days)->toEqual(25);
});

test('a manual campaign keeps the timer it was given', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => [MonsterExpansion::PICKING_BONES->name],
        'max_days_automatic' => false,
        'max_days' => 7,
    ]);

    expect($campaign->max_days)->toEqual(7)
        // Still offered, which is what the form shows underneath the field.
        ->and($campaign->suggestedMaxDays())->toEqual(40);
});

test('creating a campaign on automatic works its timer out from the expansions', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Automatic',
        'description' => 'Timer from the box',
        'expansions' => [MonsterExpansion::ANCIENT_FOREST->name, MonsterExpansion::PICKING_BONES->name],
        'max_days_automatic' => true,
        // A number the client had no business sending. It is not what lands.
        'max_days' => 1,
    ])->assertSessionHasNoErrors();

    expect(Campaign::where('name', 'Automatic')->sole())
        // 25 for the base game, which adds nothing of its own, plus 15.
        ->max_days->toEqual(40)
        ->expansions->toEqual([MonsterExpansion::ANCIENT_FOREST->name, MonsterExpansion::PICKING_BONES->name]);
});

test('creating a campaign on manual keeps the number that was typed', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Manual',
        'description' => 'Timer by hand',
        'expansions' => [MonsterExpansion::ANCIENT_FOREST->name, MonsterExpansion::PICKING_BONES->name],
        'max_days_automatic' => false,
        'max_days' => 12,
    ])->assertSessionHasNoErrors();

    expect(Campaign::where('name', 'Manual')->sole()->max_days)->toEqual(12);
});

test('a manual campaign still has to say how many days it gets', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'No timer',
        'max_days_automatic' => false,
    ])->assertSessionHasErrors('max_days', errorBag: 'createCampaign');

    expect(Campaign::where('name', 'No timer')->exists())->toBeFalse();
});

test('an automatic campaign does not have to say anything about days', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Nothing typed',
        'max_days_automatic' => true,
    ])->assertSessionHasNoErrors();

    expect(Campaign::where('name', 'Nothing typed')->sole()->max_days)->toEqual(25);
});

test('an expansion that is not a real one is refused', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Made up',
        'max_days_automatic' => true,
        'expansions' => [MonsterExpansion::ANCIENT_FOREST->name, 'MONSTER_HUNTER_MONOPOLY'],
    ])->assertSessionHasErrors('expansions.1', errorBag: 'createCampaign');

    expect(Campaign::where('name', 'Made up')->exists())->toBeFalse();
});

test('the same expansion twice is refused', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Doubled',
        'max_days_automatic' => true,
        'expansions' => [
            MonsterExpansion::ANCIENT_FOREST->name,
            MonsterExpansion::PICKING_BONES->name,
            MonsterExpansion::PICKING_BONES->name,
        ],
    ])->assertSessionHasErrors('expansions.1', errorBag: 'createCampaign');
});

test('changing the expansions of an automatic campaign moves its timer', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'max_days_automatic' => true,
        'expansions' => [],
    ]);

    $this->put(route('campaigns.update', $campaign), [
        'name' => $campaign->name,
        'description' => $campaign->description,
        'max_days_automatic' => true,
        'expansions' => [MonsterExpansion::ANCIENT_FOREST->name, MonsterExpansion::PICKING_BONES->name],
    ])->assertStatus(303)->assertSessionHasNoErrors();

    expect($campaign->refresh()->max_days)->toEqual(40);
});

test('both campaign forms are given the expansions and the base timer', function (): void {
    $campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);

    foreach ([route('campaigns.create'), route('campaigns.edit', $campaign)] as $url) {
        $this->get($url)->assertInertia(
            fn (Inertia\Testing\AssertableInertia $page) => $page
                ->has('expansions', count(MonsterExpansion::cases()))
                ->where('expansions.0.key', MonsterExpansion::cases()[0]->name)
                ->has('expansions.0.extra_days')
                ->where('baseMaxDays', Campaign::BASE_MAX_DAYS)
        );
    }
});

test('every expansion whose rules mention extra days declares that number', function (): void {
    // The rule text and `extraCampaignDays()` are two statements of the same
    // fact in two files, and nothing else ties them together: a new expansion
    // whose rules say "add 10 days" while the enum still answers 0 would give
    // every campaign that ticks it a timer ten days short, silently.
    $rules = require resource_path('lang/en/campaign-rules.php');

    foreach ($rules['expansions'] as $name => $lines) {
        $claimed = 0;

        foreach ($lines as $line) {
            if (preg_match('/\badd (\d+) days?\b/i', $line, $matches)) {
                $claimed += (int) $matches[1];
            }
        }

        expect(MonsterExpansion::fromName($name)->extraCampaignDays())
            ->toEqual($claimed, "$name's rules and extraCampaignDays() disagree.");
    }
});

test('a campaign has to be played out of at least one base game', function (): void {
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Boxless',
        'max_days_automatic' => true,
        'expansions' => [MonsterExpansion::PICKING_BONES->name],
    ])->assertSessionHasErrors(
        // The message, not just the key: the form shows whatever the server
        // sends under `expansions`, and the client-side guard
        // (`resources/js/campaign.ts`) writes the same sentence into the same
        // slot, so a reader gets one wording whichever side refuses them.
        ['expansions' => 'Pick at least one of the base games.'],
        errorBag: 'createCampaign',
    );

    expect(Campaign::where('name', 'Boxless')->exists())->toBeFalse();
});

test('editing a campaign also refuses to drop its last base game', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => [MonsterExpansion::ANCIENT_FOREST->name],
    ]);

    $this->put(route('campaigns.update', $campaign), [
        'name' => $campaign->name,
        'max_days' => $campaign->max_days,
        'expansions' => [MonsterExpansion::PICKING_BONES->name],
    ])->assertSessionHasErrors(
        ['expansions' => 'Pick at least one of the base games.'],
        errorBag: 'updateCampaign',
    );

    expect($campaign->refresh()->expansions)->toEqual([MonsterExpansion::ANCIENT_FOREST->name]);
});

test('the create page is told which box to start out ticked', function (): void {
    $this->get(route('campaigns.create'))->assertInertia(
        fn (Inertia\Testing\AssertableInertia $page) => $page
            ->where('defaultExpansions', [MonsterExpansion::defaultCampaignBox()->name])
    );

    // The default has to be a box a campaign can actually be played out of, or
    // the create form would open ticked and still fail its own guard.
    expect(MonsterExpansion::defaultCampaignBox()->isBaseGame())->toBeTrue()
        ->and(MonsterExpansion::defaultCampaignBox())->toBe(MonsterExpansion::ANCIENT_FOREST);
});

test('an empty set of expansions is refused as well', function (): void {
    // What the create form posts before anything is ticked, so it is the path
    // a real person hits, not a hand-built payload.
    $this->post(route('campaigns.store'), [
        'team_id' => $this->user->currentTeam->id,
        'name' => 'Nothing ticked',
        'max_days_automatic' => true,
        'expansions' => [],
    ])->assertSessionHasErrors('expansions', errorBag: 'createCampaign');
});

test('a request that never mentions expansions leaves them alone', function (): void {
    // Which is what keeps a plain rename working, and every campaign stored
    // before the column existed saveable.
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'expansions' => null,
    ]);

    $this->put(route('campaigns.update', $campaign), [
        'name' => 'Renamed',
        'max_days' => $campaign->max_days,
    ])->assertStatus(303)->assertSessionHasNoErrors();

    expect($campaign->refresh())->name->toEqual('Renamed')->expansions->toBeNull();
});

test('either base game on its own is enough, and both together are fine', function (): void {
    foreach ([
        [MonsterExpansion::ANCIENT_FOREST->name],
        [MonsterExpansion::WILDSPIRE_WASTE->name],
        MonsterExpansion::baseGameNames(),
    ] as $index => $boxes) {
        $this->post(route('campaigns.store'), [
            'team_id' => $this->user->currentTeam->id,
            'name' => "Box set $index",
            'max_days_automatic' => true,
            'expansions' => $boxes,
        ])->assertSessionHasNoErrors();

        // Neither base game lengthens the timer; 25 is what the core rulebook
        // gives you whichever of the two you own.
        expect(Campaign::where('name', "Box set $index")->sole()->max_days)->toEqual(25);
    }
});

test('the two base games are the ones the enum says they are', function (): void {
    expect(MonsterExpansion::baseGameNames())->toEqual(['ANCIENT_FOREST', 'WILDSPIRE_WASTE'])
        ->and(MonsterExpansion::ANCIENT_FOREST->isBaseGame())->toBeTrue()
        ->and(MonsterExpansion::PICKING_BONES->isBaseGame())->toBeFalse();
});

test('the forms are told which options are a base game', function (): void {
    $this->get(route('campaigns.create'))->assertInertia(
        fn (Inertia\Testing\AssertableInertia $page) => $page
            ->where('expansions.0.key', 'ANCIENT_FOREST')
            ->where('expansions.0.base_game', true)
            ->where('expansions.3.key', 'PICKING_BONES')
            ->where('expansions.3.base_game', false)
    );
});
