<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Campaign;
use App\Models\WeaponType;
use Illuminate\Support\Collection;

beforeEach(function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $campaign->id]);
    $this->type = WeaponType::factory()->create();

    $this->weapon = function (?Weapon $parent = null, int $rarity = 1, array $items = []): Weapon {
        $weapon = Weapon::factory()->create([
            'type_id' => $this->type->id,
            'parent_id' => $parent?->id,
            'rarity' => $rarity,
            'is_default' => $parent === null,
        ]);

        $recipe = $weapon->recipes->first();
        $recipe->update(['branch' => 'mineral']);

        foreach ($items as $item) {
            $recipe->items()->attach($item['item'], ['number' => $item['number'], 'weapon_id' => $weapon->id]);
        }

        return $weapon->fresh(['recipes.items']);
    };

    $this->find = fn (Collection $tree, Weapon $weapon): Weapon => $tree->flatMap(fn (array $entry) => $entry['paths']->flatMap(fn (array $path) => $path['weapons']))
        ->firstWhere('id', $weapon->id);
});

test('a weapon whose parent is already in hand has nothing missing before it', function (): void {
    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2);
    $leaf = ($this->weapon)($middle, 3);

    $this->hunter->weapons()->attach($middle);
    $this->hunter->load('weapons');

    $found = ($this->find)(create_weapon_tree($this->type, $this->hunter), $leaf);

    expect($found->missing_chain->pluck('id')->all())->toEqual([])
        ->and($found->chain_items->all())->toEqual([]);
});

test('the starting weapon of a line is never missing', function (): void {
    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2);

    $found = ($this->find)(create_weapon_tree($this->type, $this->hunter), $middle);

    expect($found->missing_chain->pluck('id')->all())->toEqual([]);
});

test('the chain holds every ancestor the hunter has still to build, root first', function (): void {
    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2);
    $leaf = ($this->weapon)($middle, 3);
    $tip = ($this->weapon)($leaf, 4);

    $found = ($this->find)(create_weapon_tree($this->type, $this->hunter), $tip);

    expect($found->missing_chain->pluck('id')->all())->toEqual([$middle->id, $leaf->id]);
});

test('the chain stops at an ancestor already in hand', function (): void {
    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2);
    $leaf = ($this->weapon)($middle, 3);
    $tip = ($this->weapon)($leaf, 4);

    $this->hunter->weapons()->attach($middle);
    $this->hunter->load('weapons');

    $found = ($this->find)(create_weapon_tree($this->type, $this->hunter), $tip);

    expect($found->missing_chain->pluck('id')->all())->toEqual([$leaf->id]);
});

test('the chain adds up what every missing ancestor costs', function (): void {
    $ore = Item::factory()->create(['name' => ['en' => 'Machalite Ore', 'es' => 'Mineral']]);
    $bone = Item::factory()->create(['name' => ['en' => 'Monster Bone', 'es' => 'Hueso']]);

    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2, [['item' => $ore, 'number' => 2]]);
    $leaf = ($this->weapon)($middle, 3, [
        ['item' => $ore, 'number' => 3],
        ['item' => $bone, 'number' => 1],
    ]);
    $tip = ($this->weapon)($leaf, 4, [['item' => $bone, 'number' => 5]]);

    $found = ($this->find)(create_weapon_tree($this->type, $this->hunter), $tip);

    expect($found->chain_items->pluck('number', 'id')->all())
        ->toEqual([$ore->id => 5, $bone->id => 1]);
});

test('the cost of an ancestor buildable two ways is the recipe the hunter can pay for', function (): void {
    $scale = Item::factory()->create(['name' => ['en' => 'Teostra Scale', 'es' => 'Escama']]);
    $webbing = Item::factory()->create(['name' => ['en' => 'Daora Webbing', 'es' => 'Telaraña']]);

    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2, [['item' => $scale, 'number' => 4]]);
    $second = $middle->recipes()->create(['branch' => 'Kushala Daora', 'position' => 1]);
    $second->items()->attach($webbing, ['number' => 1, 'weapon_id' => $middle->id]);

    $leaf = ($this->weapon)($middle, 3);

    $this->hunter->items()->attach($webbing, ['number' => 1]);
    $this->hunter->load('items');

    $found = ($this->find)(create_weapon_tree($this->type, $this->hunter), $leaf);

    expect($found->chain_items->pluck('number', 'id')->all())->toEqual([$webbing->id => 1]);
});

test('the wiki tree carries no chain, since nobody is holding it', function (): void {
    $root = ($this->weapon)();
    $middle = ($this->weapon)($root, 2);
    $leaf = ($this->weapon)($middle, 3);

    $found = ($this->find)(create_weapon_tree($this->type), $leaf);

    expect($found->missing_chain->pluck('id')->all())->toEqual([])
        ->and($found->chain_items->all())->toEqual([]);
});
