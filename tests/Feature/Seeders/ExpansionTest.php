<?php

use App\Models\Armor;
use App\Models\Weapon;
use App\Enum\MonsterExpansion;
use Database\Seeders\ItemsSeeder;
use Database\Seeders\ArmorsSeeder;
use Database\Seeders\WeaponsSeeder;
use Database\Seeders\ArmorSkillsSeeder;

/**
 * Every weapon and armour declares the box it comes from, and the list was
 * validated but never seeded, so nothing could be filtered by expansion.
 */
beforeEach(function (): void {
    $this->seed(ItemsSeeder::class);
});

test('a recipe records the expansion its branch belongs to', function (): void {
    $this->seed(WeaponsSeeder::class);

    $anja = Weapon::where('name->en', 'Anja Cyclone')->firstOrFail();

    expect($anja->recipes->first()->expansion)->toBe(MonsterExpansion::ANCIENT_FOREST);
});

test('a weapon built from either of two monsters records an expansion for each', function (): void {
    // The expansion pairs with the branch by position, the way the materials do.
    $this->seed(WeaponsSeeder::class);

    $twin = Weapon::where('name->en', 'Twin Nails')->firstOrFail();

    expect($twin->recipes->pluck('expansion')->all())
        ->toBe([MonsterExpansion::TEOSTRA_EXPANSION, MonsterExpansion::KUSHALA_EXPANSION]);
});

test('a weapon generic to every box records no expansion', function (): void {
    $this->seed(WeaponsSeeder::class);

    $buster = Weapon::where('name->en', 'Buster Sword')->firstOrFail();

    expect($buster->recipes->first()->expansion)->toBeNull();
});

test('an armour records its expansion', function (): void {
    $this->seed(ArmorSkillsSeeder::class);
    $this->seed(ArmorsSeeder::class);

    $anja = Armor::where('name->en', 'Anja Helm')->firstOrFail();

    expect($anja->expansion)->toBe(MonsterExpansion::ANCIENT_FOREST);
});
