<?php

use App\Models\User;
use App\Models\Armor;
use App\Enum\ArmorType;
use App\Enum\MonsterExpansion;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    foreach ([ArmorType::HEAD, ArmorType::BODY, ArmorType::LEG] as $slot) {
        Armor::factory()->create([
            'type' => $slot,
            'branch' => 'Anjanath',
            'rarity' => 3,
            'expansion' => MonsterExpansion::ANCIENT_FOREST,
            'name' => ['en' => 'Anja '.$slot->name, 'es' => 'Anja '.$slot->name],
        ]);
    }

    Armor::factory()->create([
        'type' => ArmorType::HEAD,
        'branch' => 'Rathalos',
        'rarity' => 4,
        'expansion' => MonsterExpansion::WILDSPIRE_WASTE,
        'name' => ['en' => 'Rathalos Helm', 'es' => 'Yelmo de Rathalos'],
    ]);
});

test('the index groups the pieces by the monster they come from', function (): void {
    $this->get(route('wiki.armor.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Armor/Index')
            ->has('branches', 2)
            ->where('branches.0.branch', 'Anjanath')
            ->has('branches.0.pieces.head')
            ->has('branches.0.pieces.body')
            ->has('branches.0.pieces.leg'));
});

test('a name narrows the list, in either language', function (): void {
    $this->get(route('wiki.armor.index', ['q' => 'Yelmo de Rathalos']))
        ->assertInertia(fn (AssertableInertia $page) => $page->has('branches', 1)
            ->where('branches.0.branch', 'Rathalos'));
});

test('a rarity narrows the list', function (): void {
    $this->get(route('wiki.armor.index', ['rarity' => 4]))
        ->assertInertia(fn (AssertableInertia $page) => $page->has('branches', 1));
});

test('an expansion narrows the list', function (): void {
    $this->get(route('wiki.armor.index', ['expansion' => MonsterExpansion::ANCIENT_FOREST->name]))
        ->assertInertia(fn (AssertableInertia $page) => $page->has('branches', 1)
            ->where('branches.0.branch', 'Anjanath'));
});

test('a search matching nothing comes back with no branches', function (): void {
    $this->get(route('wiki.armor.index', ['q' => 'Nergigante']))
        ->assertInertia(fn (AssertableInertia $page) => $page->has('branches', 0));
});

test('an armour has a card of its own', function (): void {
    $armor = Armor::where('branch', 'Rathalos')->firstOrFail();

    $this->get(route('wiki.armor.show', $armor))
        ->assertStatus(200)
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Armor/Detail')
            ->where('armor.id', $armor->id)
            ->has('armor.skills')
            ->has('armor.items'));
});
