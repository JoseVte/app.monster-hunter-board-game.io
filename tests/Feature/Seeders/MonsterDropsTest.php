<?php

use App\Models\Item;
use App\Models\Monster;
use Database\Seeders\ItemsSeeder;
use Database\Seeders\MonstersSeeder;

/**
 * Every monster declares what it drops, and the list was validated but never
 * seeded, so nothing on a screen could say which monster a part came from.
 */
beforeEach(function (): void {
    $this->seed(ItemsSeeder::class);
    $this->seed(MonstersSeeder::class);
});

test('a monster carries the parts it drops', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();

    expect($jagras->items->pluck('name'))
        ->toContain('Great Jagras Hide')
        ->toContain('Great Jagras Mane');
});

test('a part knows the monsters it comes from', function (): void {
    $hide = Item::where('name->en', 'Great Jagras Hide')->firstOrFail();

    expect($hide->monsters->pluck('name'))->toContain('Great Jagras');
});

test('a part shared by several monsters is listed under each', function (): void {
    // Only four of the hundred and five parts drop from more than one monster,
    // but those four are why this is a pivot and not a column on the item.
    $sac = Item::where('name->en', 'Inferno Sac')->firstOrFail();

    expect($sac->monsters->count())->toBe(3);
});

test('seeding twice does not double the links', function (): void {
    $before = Monster::where('name->en', 'Great Jagras')->firstOrFail()->items()->count();

    $this->seed(MonstersSeeder::class);

    expect(Monster::where('name->en', 'Great Jagras')->firstOrFail()->items()->count())->toBe($before);
});

test('a monster carries its resistances', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();

    expect($jagras->resistance_fire)->toBe(1)
        ->and($jagras->resistance_water)->toBeNull()
        ->and($jagras->resistance_thunder)->toBe(2)
        ->and($jagras->resistance_nitro)->toBe(1)
        ->and($jagras->resistance_stun)->toBe(2);
});

test('a monster with special rules carries its setup and mechanics', function (): void {
    $teostra = Monster::where('name->en', 'Teostra')->firstOrFail();

    expect($teostra->setup)->toContain('Supernova')
        ->and($teostra->mechanics)->toHaveCount(2)
        ->and($teostra->mechanics[0]['title'])->toBe('Blackscale Dust Tokens');
});

test('a monster with no special rules carries neither', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();

    expect($jagras->setup)->toBeEmpty()
        ->and($jagras->mechanics)->toBeEmpty();
});

test('a monster carries its difficulty tiers and body-part breaks', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();
    $easy = $jagras->difficulties->firstWhere('stars', 1);

    expect($jagras->difficulties)->toHaveCount(3)
        ->and($easy->health)->toBe(50)
        ->and($easy->ability_name)->toBe('Gluttonous')
        ->and($easy->parts)->toHaveCount(3)
        ->and($easy->parts[0]->icon)->toBe('head')
        ->and($easy->parts[0]->defense)->toBe(0)
        ->and($easy->parts[0]->broken)->toBe(4)
        ->and($easy->parts[2]->ability_broken)->toBeEmpty();
});

test('seeding twice does not double the difficulty tiers or parts', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();
    $before = $jagras->difficulties->sum(fn ($tier) => $tier->parts->count());

    $this->seed(MonstersSeeder::class);
    $jagras->refresh();

    expect($jagras->difficulties)->toHaveCount(3)
        ->and($jagras->difficulties->sum(fn ($tier) => $tier->parts->count()))->toBe($before);
});

test('a monster carries its reward table', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();

    expect($jagras->rewards)->toHaveCount(12)
        ->and($jagras->rewards->firstWhere('roll', 1)->item->name)->toBe('Monster Bone Small')
        ->and($jagras->rewards->firstWhere('roll', 6)->extra)->toContain('claw_icon')
        ->and($jagras->rewards->firstWhere('roll', 12)->item->name)->toBe('Great Jagras Mane')
        ->and($jagras->rewards->firstWhere('roll', 12)->extra)->toContain('head_icon');
});

test('seeding twice does not double the reward rows', function (): void {
    $jagras = Monster::where('name->en', 'Great Jagras')->firstOrFail();

    $this->seed(MonstersSeeder::class);
    $jagras->refresh();

    expect($jagras->rewards)->toHaveCount(12);
});
