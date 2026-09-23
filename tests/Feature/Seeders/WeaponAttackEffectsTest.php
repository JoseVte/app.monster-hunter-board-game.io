<?php

use App\Models\Weapon;
use Database\Seeders\ItemsSeeder;
use Database\Seeders\WeaponsSeeder;

/**
 * What a weapon's attacks do beyond damage: the one element it carries and the
 * statuses it can inflict. Both were declared in the seed data and read by
 * nothing, which is why the wiki could say what an upgrade costs but not what
 * it changes about the hit.
 */
beforeEach(function (): void {
    $this->seed(ItemsSeeder::class);
    $this->seed(WeaponsSeeder::class);
});

test('a weapon records the element its attacks carry', function (): void {
    $blitz = Weapon::where('name->en', 'Flame Blitz')->firstOrFail();

    expect($blitz->element)->toBe('fire');
});

test('a weapon records every status its attacks can inflict', function (): void {
    $blitz = Weapon::where('name->en', 'Jagras Blitz')->firstOrFail();

    expect($blitz->status_attacks)->toBe(['stun', 'poison']);
});

test('a weapon that carries neither says so with a null and an empty list', function (): void {
    $iron = Weapon::where('name->en', 'Iron Bow')->firstOrFail();

    expect($iron->element)->toBeNull()
        ->and($iron->status_attacks)->toBe([]);
});

test('the element is the single one the data names, not the list it is written as', function (): void {
    // Every entry is a one item list, so the column holds the element itself
    // rather than a list a page would have to unwrap.
    $water = Weapon::where('name->en', 'Madness Rifle')->firstOrFail();

    expect($water->element)->toBeString();
});

test('having elemental attacks is inferred from the element, not declared beside it', function (): void {
    // The data used to carry a `has_elemental_attacks` flag next to the list,
    // and fifty-three weapons set the flag without ever naming an element.
    $elemental = Weapon::where('name->en', 'Flame Blitz')->firstOrFail();
    $plain = Weapon::where('name->en', 'Iron Bow')->firstOrFail();

    expect($elemental->has_elemental_attacks)->toBeTrue()
        ->and($plain->has_elemental_attacks)->toBeFalse();
});
