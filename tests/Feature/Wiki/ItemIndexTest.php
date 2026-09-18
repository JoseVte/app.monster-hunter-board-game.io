<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Enum\ItemType;
use App\Models\Weapon;
use App\Models\Monster;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $this->bone = Item::factory()->create([
        'name' => ['en' => 'Bone', 'es' => 'Hueso'],
        'type' => ItemType::COMMON->name,
    ]);

    $this->fang = Item::factory()->create([
        'name' => ['en' => 'Anjanath Fang', 'es' => 'Colmillo de Anjanath'],
        'type' => ItemType::MONSTER_PART->name,
    ]);

    $this->potion = Item::factory()->create([
        'name' => ['en' => 'Potion', 'es' => 'Poción'],
        'type' => ItemType::OTHER->name,
    ]);
});

test('the index lists every item, flat', function (): void {
    $this->get(route('wiki.item.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Item/Index')
            ->has('items', 3));
});

test('a name narrows the list, in either language', function (): void {
    $this->get(route('wiki.item.index', ['q' => 'Colmillo de Anjanath']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('items', 1)
            ->where('items.0.id', $this->fang->id));
});

test('a type narrows the list', function (): void {
    $this->get(route('wiki.item.index', ['type' => ItemType::COMMON->name]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('items', 1)
            ->where('items.0.id', $this->bone->id));
});

test('by default items sort by type: common, other, then monster part', function (): void {
    $this->get(route('wiki.item.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('items.0.id', $this->bone->id)
            ->where('items.1.id', $this->potion->id)
            ->where('items.2.id', $this->fang->id)
            ->where('filters.sort', 'type')
            ->where('filters.direction', 'asc'));
});

test('sort=name orders alphabetically instead', function (): void {
    // Anjanath Fang, Bone, Potion.
    $this->get(route('wiki.item.index', ['sort' => 'name']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('items.0.id', $this->fang->id)
            ->where('items.1.id', $this->bone->id)
            ->where('items.2.id', $this->potion->id));
});

test('a name that is a prefix of another still sorts before it', function (): void {
    // MySQL compares a bare json_extract() as a JSON value rather than as
    // text, and coercing it with lower()/cast() to get a plain string flips
    // this exact pair: the longer name landed first. Sorting in PHP is what
    // keeps it in the order a reader would expect regardless of driver.
    $rathalos = Item::factory()->create(['name' => ['en' => 'Rathalos Scale', 'es' => 'Escama de Rathalos']]);
    $rathalosPlus = Item::factory()->create(['name' => ['en' => 'Rathalos Scale+', 'es' => 'Escama de Rathalos+']]);

    $this->get(route('wiki.item.index', ['sort' => 'name']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('items.3.id', $rathalos->id)
            ->where('items.4.id', $rathalosPlus->id));
});

test('direction=desc reverses whichever sort is active', function (): void {
    $this->get(route('wiki.item.index', ['direction' => 'desc']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('items.0.id', $this->fang->id)
            ->where('items.1.id', $this->potion->id)
            ->where('items.2.id', $this->bone->id));
});

test('an unknown sort or direction falls back to the default rather than breaking', function (): void {
    $this->get(route('wiki.item.index', ['sort' => 'rarity', 'direction' => 'sideways']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('filters.sort', 'type')
            ->where('filters.direction', 'asc'));
});

test('an item has a card of its own, with where it comes from and what it is for', function (): void {
    $monster = Monster::factory()->create();
    $this->fang->monsters()->attach($monster);

    $weapon = Weapon::factory()->create(['is_default' => false]);
    $weapon->recipes->first()->items()->attach($this->fang, ['number' => 1, 'weapon_id' => $weapon->id]);

    $armor = Armor::factory()->create(['is_default' => false]);
    $armor->items()->attach($this->fang, ['number' => 1]);

    $this->get(route('wiki.item.show', $this->fang))
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Item/Show')
            ->where('item.id', $this->fang->id)
            ->has('item.monsters', 1)
            ->has('item.weapons', 1)
            ->where('item.weapons.0.id', $weapon->id)
            ->has('item.armors', 1)
            ->where('item.armors.0.id', $armor->id));
});

test('an item used by both recipes of the same weapon is not listed twice', function (): void {
    $weapon = Weapon::factory()->create(['is_default' => false]);
    $secondRecipe = $weapon->recipes()->create(['position' => 1]);

    $weapon->recipes->first()->items()->attach($this->fang, ['number' => 1, 'weapon_id' => $weapon->id]);
    $secondRecipe->items()->attach($this->fang, ['number' => 2, 'weapon_id' => $weapon->id]);

    $this->get(route('wiki.item.show', $this->fang))
        ->assertInertia(fn (AssertableInertia $page) => $page->has('item.weapons', 1));
});
