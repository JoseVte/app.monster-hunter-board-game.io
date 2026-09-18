<?php

use App\Models\User;
use App\Models\Weapon;
use App\Models\WeaponType;
use App\Enum\MonsterExpansion;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $this->greatSword = WeaponType::factory()->create(['name' => ['en' => 'Great Sword', 'es' => 'Gran Espada']]);
    $this->bow = WeaponType::factory()->create(['name' => ['en' => 'Bow', 'es' => 'Arco']]);

    $this->buster = Weapon::factory()->create([
        'type_id' => $this->greatSword->id,
        'name' => ['en' => 'Buster Sword', 'es' => 'Espada Cazadora'],
        'rarity' => 1,
    ]);
    $this->buster->recipes->first()->update(['expansion' => MonsterExpansion::ANCIENT_FOREST]);

    $this->anja = Weapon::factory()->create([
        'type_id' => $this->greatSword->id,
        'name' => ['en' => 'Anja Blade', 'es' => 'Hoja de Anjanath'],
        'rarity' => 3,
    ]);
    $this->anja->recipes->first()->update(['expansion' => MonsterExpansion::WILDSPIRE_WASTE]);
});

test('the index counts what each type has to show', function (): void {
    $this->get(route('wiki.weapon.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Weapon/Index')
            ->has('weaponTypes', 2)
            ->where('weaponTypes.0.weapons_count', 2)
            ->where('weaponTypes.1.weapons_count', 0));
});

test('a name narrows the count, in either language', function (): void {
    $this->get(route('wiki.weapon.index', ['q' => 'Anjanath']))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('weaponTypes.0.weapons_count', 1));

    $this->get(route('wiki.weapon.index', ['q' => 'Buster']))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('weaponTypes.0.weapons_count', 1));
});

test('a rarity narrows the count', function (): void {
    $this->get(route('wiki.weapon.index', ['rarity' => 3]))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('weaponTypes.0.weapons_count', 1));
});

test('an expansion narrows the count through the recipe', function (): void {
    $this->get(route('wiki.weapon.index', ['expansion' => MonsterExpansion::ANCIENT_FOREST->name]))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('weaponTypes.0.weapons_count', 1));
});

test('a type shows its whole tree and marks what matches', function (): void {
    // The tree keeps every weapon: a line with a gap in it reads as broken.
    $this->get(route('wiki.weapon.type', [$this->greatSword, 'q' => 'Anjanath']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Weapon/Show')
            ->has('weapons')
            ->where('matching', [$this->anja->id])
            ->where('filters.q', 'Anjanath'));
});

test('the tree is built without a hunter', function (): void {
    $this->get(route('wiki.weapon.type', [$this->greatSword]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('weapons.0.root.equipped', null)
            ->where('weapons.0.root.can_craft', false));
});

test('a weapon has a card of its own', function (): void {
    // The route the search results and the searchable index both point at.
    $this->get(route('wiki.weapon.show', $this->anja))
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Weapon/Detail')
            ->where('weapon.id', $this->anja->id)
            ->has('weapon.recipes.0.items')
            ->has('weapon.type'));
});
