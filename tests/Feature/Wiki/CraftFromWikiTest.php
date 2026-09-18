<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Campaign;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());

    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    // The campaign factory already puts its creator in, so the membership is
    // pointed at the hunter rather than added again.
    $this->campaign->users()->syncWithoutDetaching([
        $this->user->id => ['role_id' => 1, 'hunter_id' => $this->hunter->id],
    ]);

    $this->hide = Item::factory()->create();

    $this->weapon = Weapon::factory()->create(['is_default' => false]);
    $this->weapon->recipes->first()->items()->attach($this->hide, ['number' => 2, 'weapon_id' => $this->weapon->id]);
    $this->weapon->load('recipes.items');
});

test('a weapon card lists the hunters that are yours', function (): void {
    // Another member's hunter in the same campaign is not one of yours.
    $someoneElse = User::factory()->withPersonalTeam()->create();
    $theirs = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);

    // HunterFactory points the campaign owner's membership at every hunter it
    // makes, so this one has to be handed over and ours pointed back.
    $this->campaign->users()->syncWithoutDetaching([
        $someoneElse->id => ['role_id' => 1, 'hunter_id' => $theirs->id],
    ]);
    $this->campaign->users()->updateExistingPivot($this->user->id, ['hunter_id' => $this->hunter->id]);

    $this->get(route('wiki.weapon.show', $this->weapon))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('hunters', 1)
            ->where('hunters.0.id', $this->hunter->id)
            ->where('hunters.0.campaign', $this->campaign->name));
});

test('a hunter short of the parts is listed but cannot craft', function (): void {
    $this->get(route('wiki.weapon.show', $this->weapon))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('hunters.0.can_craft', false));
});

test('a hunter short of the parts sees only the shortfall, per recipe', function (): void {
    $recipe = $this->weapon->recipes->first();
    // Owns one of the two the recipe needs, so only the gap is reported.
    $this->hunter->items()->attach($this->hide, ['number' => 1]);

    $this->get(route('wiki.weapon.show', $this->weapon))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has("hunters.0.missing_by_recipe.{$recipe->id}", 1)
            ->where("hunters.0.missing_by_recipe.{$recipe->id}.0.name", $this->hide->name)
            ->where("hunters.0.missing_by_recipe.{$recipe->id}.0.missing", 1));
});

test('a hunter who already owns the weapon is told so', function (): void {
    $this->hunter->weapons()->attach($this->weapon->id);

    $this->get(route('wiki.weapon.show', $this->weapon))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('hunters.0.owned', true));
});

test('an upgrade with the previous weapon still out there says which one', function (): void {
    $upgrade = Weapon::factory()->create(['is_default' => false, 'parent_id' => $this->weapon->id]);

    $this->get(route('wiki.weapon.show', $upgrade))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('hunters.0.parent_owned', false));

    $this->hunter->weapons()->attach($this->weapon->id);

    $this->get(route('wiki.weapon.show', $upgrade))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('hunters.0.parent_owned', true));
});

test('a hunter with the parts can craft', function (): void {
    $this->hunter->items()->attach($this->hide, ['number' => 2]);

    $this->get(route('wiki.weapon.show', $this->weapon))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('hunters.0.can_craft', true)
            ->has('hunters.0.craftable_recipes', 1));
});

test('an armour card lists them too', function (): void {
    $armor = Armor::factory()->create(['is_default' => false]);
    $armor->items()->attach($this->hide, ['number' => 1]);
    $this->hunter->items()->attach($this->hide, ['number' => 1]);

    $this->get(route('wiki.armor.show', $armor))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('hunters', 1)
            ->where('hunters.0.can_craft', true));
});

test('an armour short of the parts says what is missing', function (): void {
    $armor = Armor::factory()->create(['is_default' => false]);
    $armor->items()->attach($this->hide, ['number' => 3]);

    $this->get(route('wiki.armor.show', $armor))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('hunters.0.can_craft', false)
            ->has('hunters.0.missing', 1)
            ->where('hunters.0.missing.0.name', $this->hide->name)
            ->where('hunters.0.missing.0.missing', 3));
});

test('a hunter who already owns the armour is told so', function (): void {
    $armor = Armor::factory()->create(['is_default' => false]);
    $this->hunter->armors()->attach($armor->id);

    $this->get(route('wiki.armor.show', $armor))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('hunters.0.can_craft', false)
            ->where('hunters.0.owned', true));
});

test('a visitor with no hunters gets an empty list', function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $this->get(route('wiki.weapon.show', $this->weapon))
        ->assertInertia(fn (AssertableInertia $page) => $page->has('hunters', 0));
});
