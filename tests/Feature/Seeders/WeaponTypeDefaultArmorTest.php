<?php

use App\Models\WeaponType;
use Database\Seeders\ItemsSeeder;
use Database\Seeders\WeaponsSeeder;

/**
 * A weapon type grants a point of armour in one slot, which a hunter keeps only
 * while nothing of their own is worn there.
 */
beforeEach(function (): void {
    $this->seed(ItemsSeeder::class);
    $this->seed(WeaponsSeeder::class);
});

test('a weapon type records the armour it grants, keyed by the slot', function (): void {
    $bow = WeaponType::where('name->en', 'Bow')->firstOrFail();

    // toEqual, not toBe: MySQL reorders the keys of a JSON object and the test
    // connection is sqlite, which keeps them, so a strict compare would pass
    // here and fail on the server.
    expect($bow->default_armor)->toEqual(['head' => 0, 'body' => 0, 'leg' => 1]);
});

test('the slot differs from one type to the next', function (): void {
    $hammer = WeaponType::where('name->en', 'Hammer')->firstOrFail();

    expect($hammer->default_armor)->toEqual(['head' => 0, 'body' => 1, 'leg' => 0]);
});

test('every type grants armour in exactly one slot', function (): void {
    // The data writes it positionally, head first, so a type that granted two
    // or none would mean the list had drifted from what the cards print.
    WeaponType::all()->each(function (WeaponType $type): void {
        expect(array_sum($type->default_armor))->toBe(1, $type->getTranslation('name', 'en'));
    });
});
