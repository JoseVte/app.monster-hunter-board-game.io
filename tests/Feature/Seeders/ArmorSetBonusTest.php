<?php

use App\Models\Armor;
use App\Models\ArmorSkill;
use Database\Seeders\ItemsSeeder;
use Database\Seeders\ArmorsSeeder;
use Database\Seeders\MonstersSeeder;
use Database\Seeders\ArmorSkillsSeeder;

/**
 * A set bonus lists the three pieces it needs, and every page that reads it
 * compares those against the ids a hunter is wearing. Only `ArmorsSeeder` can
 * resolve them, since the armours do not exist when the skills are written.
 */
beforeEach(function (): void {
    $this->seed(ItemsSeeder::class);
    $this->seed(ArmorSkillsSeeder::class);
    $this->seed(MonstersSeeder::class);
    $this->seed(ArmorsSeeder::class);
});

test('a set bonus lists the pieces it needs by id', function (): void {
    $mastery = ArmorSkill::where('name->en', 'Rathalos Mastery')->firstOrFail();

    $pieces = Armor::whereIn('name->en', ['Rathalos Helm', 'Rathalos Mail', 'Rathalos Greaves'])
        ->pluck('id')
        ->all();

    expect($mastery->bonus_set_armor)->toEqualCanonicalizing($pieces);
});

test('writing the skills again leaves the ids alone', function (): void {
    // The skills seeder used to write the armour names and lean on the armours
    // seeder to swap them for ids afterwards. Run on its own, or last, it left
    // every set bonus reading as inactive however many pieces were worn.
    $this->seed(ArmorSkillsSeeder::class);

    $mastery = ArmorSkill::where('name->en', 'Rathalos Mastery')->firstOrFail();

    expect($mastery->bonus_set_armor)->each->toBeInt();
});

test('every set bonus names three pieces that exist', function (): void {
    $orphans = ArmorSkill::where('bonus_set', true)->get()
        ->reject(fn (ArmorSkill $skill): bool => count($skill->bonus_set_armor ?? []) === 3
            && Armor::whereIn('id', $skill->bonus_set_armor)->count() === 3)
        ->map(fn (ArmorSkill $skill): string => $skill->getTranslation('name', 'en'))
        ->all();

    expect(ArmorSkill::where('bonus_set', true)->count())->toBeGreaterThan(0)
        ->and($orphans)->toBeEmpty();
});
