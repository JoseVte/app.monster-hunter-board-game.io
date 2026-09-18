<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);

    $this->scale = Item::factory()->create(['name' => ['en' => 'Teostra Scale', 'es' => 'Escama']]);
    $this->webbing = Item::factory()->create(['name' => ['en' => 'Daora Webbing', 'es' => 'Telaraña']]);

    // One weapon, two ways of making it: the factory gives it the first recipe.
    $this->weapon = Weapon::factory()->create(['is_default' => false]);
    $this->fromTeostra = $this->weapon->recipes->first();
    $this->fromTeostra->update(['branch' => 'Teostra']);
    $this->fromTeostra->items()->attach($this->scale, ['number' => 2, 'weapon_id' => $this->weapon->id]);

    $this->fromKushala = $this->weapon->recipes()->create(['branch' => 'Kushala Daora', 'position' => 1]);
    $this->fromKushala->items()->attach($this->webbing, ['number' => 3, 'weapon_id' => $this->weapon->id]);

    $this->weapon->load('recipes.items');

    $this->craft = fn (array $payload = []) => $this->post(
        route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weapon->type, $this->weapon]),
        $payload,
    );
});

function giveHunter($test, Item $item, int $number): void
{
    $test->hunter->items()->attach($item, ['number' => $number]);
    $test->hunter->load('items');
}

test('a hunter with the parts for neither recipe cannot craft', function (): void {
    expect($this->hunter->canCraftWeapon($this->weapon))->toBeFalse();

    ($this->craft)()->assertStatus(400);
});

test('the parts for one recipe are enough', function (): void {
    giveHunter($this, $this->webbing, 3);

    expect($this->hunter->canCraftWeapon($this->weapon))->toBeTrue()
        ->and($this->hunter->craftableRecipes($this->weapon)->pluck('id')->all())
        ->toEqual([$this->fromKushala->id]);
});

test('crafting spends only the recipe that was affordable', function (): void {
    giveHunter($this, $this->webbing, 3);
    giveHunter($this, $this->scale, 1);

    ($this->craft)()->assertStatus(303);

    expect($this->hunter->items()->find($this->webbing->id)->pivot->number)->toEqual(0)
        ->and($this->hunter->items()->find($this->scale->id)->pivot->number)->toEqual(1)
        ->and($this->hunter->weapons()->find($this->weapon->id))->not->toBeNull();
});

test('a hunter who can afford both chooses which parts to spend', function (): void {
    giveHunter($this, $this->scale, 2);
    giveHunter($this, $this->webbing, 3);

    expect($this->hunter->craftableRecipes($this->weapon))->toHaveCount(2);

    ($this->craft)(['recipe' => $this->fromKushala->id])->assertStatus(303);

    expect($this->hunter->items()->find($this->webbing->id)->pivot->number)->toEqual(0)
        ->and($this->hunter->items()->find($this->scale->id)->pivot->number)->toEqual(2);
});

test('choosing a recipe the hunter cannot afford is refused, not swapped', function (): void {
    giveHunter($this, $this->webbing, 3);

    ($this->craft)(['recipe' => $this->fromTeostra->id])->assertStatus(400);

    expect($this->hunter->weapons()->find($this->weapon->id))->toBeNull()
        ->and($this->hunter->items()->find($this->webbing->id)->pivot->number)->toEqual(3);
});

test('a recipe belonging to another weapon is refused', function (): void {
    giveHunter($this, $this->webbing, 3);

    $other = Weapon::factory()->create(['is_default' => false]);

    ($this->craft)(['recipe' => $other->recipes->first()->id])->assertStatus(400);

    expect($this->hunter->weapons()->find($this->weapon->id))->toBeNull();
});

test('the weapon line is listed under both of its monsters', function (): void {
    $tree = create_weapon_tree($this->weapon->type, $this->hunter);

    expect($tree->keys()->all())->toEqual(['Teostra', 'Kushala Daora']);
});

test('a weapon with one recipe is still listed once', function (): void {
    $single = Weapon::factory()->create(['is_default' => false]);
    $single->recipes->first()->update(['branch' => 'mineral']);

    $tree = create_weapon_tree($single->type, $this->hunter);

    expect($tree->keys()->all())->toEqual(['mineral']);
});
