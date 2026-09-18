<?php

use App\Models\User;
use App\Models\Monster;
use App\Enum\MonsterCategory;
use App\Enum\MonsterExpansion;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $this->anjanath = Monster::factory()->create([
        'name' => ['en' => 'Anjanath', 'es' => 'Anjanath'],
        'category' => MonsterCategory::BRUTE_WYVERN,
        'expansion' => MonsterExpansion::ANCIENT_FOREST,
    ]);

    $this->rathalos = Monster::factory()->create([
        'name' => ['en' => 'Rathalos', 'es' => 'Rathalos'],
        'category' => MonsterCategory::FLYING_WYVERN,
        'expansion' => MonsterExpansion::WILDSPIRE_WASTE,
    ]);
});

test('the index lists every monster, flat', function (): void {
    $this->get(route('wiki.monster.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Monster/Index')
            ->has('monsters', 2));
});

test('a name narrows the list, in either language', function (): void {
    $this->get(route('wiki.monster.index', ['q' => 'Rathalos']))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('monsters', 1)
            ->where('monsters.0.id', $this->rathalos->id));
});

test('a category narrows the list', function (): void {
    $this->get(route('wiki.monster.index', ['category' => MonsterCategory::BRUTE_WYVERN->name]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('monsters', 1)
            ->where('monsters.0.id', $this->anjanath->id));
});

test('an expansion narrows the list', function (): void {
    $this->get(route('wiki.monster.index', ['expansion' => MonsterExpansion::WILDSPIRE_WASTE->name]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('monsters', 1)
            ->where('monsters.0.id', $this->rathalos->id));
});

test('a monster has a card of its own', function (): void {
    $this->get(route('wiki.monster.show', $this->rathalos))
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Monster/Show')
            ->where('monster.id', $this->rathalos->id));
});
