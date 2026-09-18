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

test('a weapon both monsters build is listed once, carrying both names', function (): void {
    // It used to appear under each monster, which meant crafting it twice was a
    // reasonable thing to think you could do.
    // Twin Nails hangs off a starting weapon, so it is a path rather than a root.
    $root = Weapon::factory()->create(['is_default' => true, 'type_id' => $this->weapon->type_id]);
    $this->weapon->update(['parent_id' => $root->id]);

    $tree = create_weapon_tree($this->weapon->type, $this->hunter);
    $paths = $tree->flatMap(fn (array $entry): iterable => $entry['paths']);

    expect($paths)->toHaveCount(1)
        ->and($paths->first()['branches'])->toEqual(['Teostra', 'Kushala Daora'])
        ->and($paths->first()['weapons'])->toHaveCount(1);
});

test('a weapon with one recipe carries the one branch', function (): void {
    $root = Weapon::factory()->create(['is_default' => true]);
    $single = Weapon::factory()->create(['is_default' => false, 'type_id' => $root->type_id, 'parent_id' => $root->id]);
    $single->recipes->first()->update(['branch' => 'mineral']);

    $tree = create_weapon_tree($root->type, $this->hunter);

    expect($tree->first()['paths']->first()['branches'])->toEqual(['mineral']);
});

test('a starting weapon can be equipped even though nothing granted it', function (): void {
    // A hunter owns their starting weapon from the first day, but nothing ever
    // wrote it to the pivot, so equipping it was refused and there was no way
    // back to it once anything else had been equipped.
    $starting = Weapon::factory()->create(['is_default' => true]);

    $this->put(
        route('campaigns.hunters.weapons.equip', [$this->campaign, $this->hunter, $starting->type, $starting]),
        ['equip' => true],
    )->assertStatus(303);

    expect($this->hunter->weapons()->find($starting->id)?->pivot->equipped)->toBeTruthy();
});

test('equipping a starting weapon unequips the one in hand of that type', function (): void {
    $starting = Weapon::factory()->create(['is_default' => true]);
    $other = Weapon::factory()->create(['is_default' => false, 'type_id' => $starting->type_id]);
    $this->hunter->weapons()->attach($other, ['equipped' => true]);

    $this->put(
        route('campaigns.hunters.weapons.equip', [$this->campaign, $this->hunter, $starting->type, $starting]),
        ['equip' => true],
    )->assertStatus(303);

    expect($this->hunter->weapons()->find($other->id)?->pivot->equipped)->toBeFalsy()
        ->and($this->hunter->weapons()->find($starting->id)?->pivot->equipped)->toBeTruthy();
});

test('a weapon the hunter neither owns nor started with is refused', function (): void {
    $stranger = Weapon::factory()->create(['is_default' => false]);

    $this->put(
        route('campaigns.hunters.weapons.equip', [$this->campaign, $this->hunter, $stranger->type, $stranger]),
        ['equip' => true],
    )->assertStatus(400);
});

test('a starting weapon cannot be unequipped, which would leave the hunter empty handed', function (): void {
    $starting = Weapon::factory()->create(['is_default' => true]);
    $this->hunter->weapons()->attach($starting, ['equipped' => true]);

    $this->put(
        route('campaigns.hunters.weapons.equip', [$this->campaign, $this->hunter, $starting->type, $starting]),
        ['equip' => false],
    )->assertStatus(400);

    expect($this->hunter->weapons()->find($starting->id)?->pivot->equipped)->toBeTruthy();
});

test('equipping something else is how a starting weapon leaves the hand', function (): void {
    $starting = Weapon::factory()->create(['is_default' => true]);
    $this->hunter->weapons()->attach($starting, ['equipped' => true]);
    $other = Weapon::factory()->create(['is_default' => false, 'type_id' => $starting->type_id]);
    $this->hunter->weapons()->attach($other, ['equipped' => false]);

    $this->put(
        route('campaigns.hunters.weapons.equip', [$this->campaign, $this->hunter, $other->type, $other]),
        ['equip' => true],
    )->assertStatus(303);

    expect($this->hunter->weapons()->find($starting->id)?->pivot->equipped)->toBeFalsy();
});
