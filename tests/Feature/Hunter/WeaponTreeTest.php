<?php

use App\Models\User;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Campaign;
use App\Models\WeaponType;

beforeEach(function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $campaign->id]);
    $this->type = WeaponType::factory()->create();

    $this->weapon = function (string $branch, ?Weapon $parent = null, int $rarity = 1): Weapon {
        $weapon = Weapon::factory()->create([
            'type_id' => $this->type->id,
            'parent_id' => $parent?->id,
            'rarity' => $rarity,
            'is_default' => $parent === null,
        ]);
        $weapon->recipes->first()->update(['branch' => $branch]);

        return $weapon;
    };
});

test('a root shared by several branches is listed once', function (): void {
    // The old shape repeated the starting weapon under every monster that grew
    // out of it, so Buster Sword appeared five times on one screen.
    $root = ($this->weapon)('mineral');
    ($this->weapon)('Great Jagras', $root, 2);
    ($this->weapon)('Rathalos', $root, 2);
    ($this->weapon)('Anjanath', $root, 2);

    $tree = create_weapon_tree($this->type, $this->hunter);

    expect($tree)->toHaveCount(1)
        ->and($tree->first()['root']->id)->toEqual($root->id)
        ->and($tree->first()['paths'])->toHaveCount(3);
});

test('each root keeps its own paths', function (): void {
    $mineral = ($this->weapon)('mineral');
    $bone = ($this->weapon)('bone');
    ($this->weapon)('Rathalos', $mineral, 2);
    ($this->weapon)('Anjanath', $bone, 2);

    $tree = create_weapon_tree($this->type, $this->hunter);

    expect($tree)->toHaveCount(2)
        ->and($tree->pluck('root.id')->all())->toEqual([$mineral->id, $bone->id]);
});

test('a path carries the branches it belongs to', function (): void {
    $root = ($this->weapon)('mineral');
    $shared = ($this->weapon)('Teostra', $root, 2);
    $shared->recipes()->create(['branch' => 'Kushala Daora', 'position' => 1]);

    $tree = create_weapon_tree($this->type, $this->hunter);
    $path = $tree->first()['paths']->first();

    expect($path['branches'])->toEqual(['Teostra', 'Kushala Daora']);
});

test('a weapon knows the whole path back to its root', function (): void {
    // This is what lets hovering one card light the way it was made, without
    // the browser walking parents itself.
    $root = ($this->weapon)('mineral');
    $middle = ($this->weapon)('Rathalos', $root, 2);
    $leaf = ($this->weapon)('Rathalos', $middle, 3);

    $tree = create_weapon_tree($this->type, $this->hunter);
    $path = $tree->first()['paths']->first();

    expect($path['weapons']->last()->path_ids)->toEqual([$root->id, $middle->id, $leaf->id])
        ->and($path['weapons']->first()->path_ids)->toEqual([$root->id, $middle->id]);
});

test('a path is ordered from the root outwards', function (): void {
    $root = ($this->weapon)('mineral');
    $middle = ($this->weapon)('Rathalos', $root, 2);
    $leaf = ($this->weapon)('Rathalos', $middle, 3);

    $tree = create_weapon_tree($this->type, $this->hunter);

    expect($tree->first()['paths']->first()['weapons']->pluck('id')->all())
        ->toEqual([$middle->id, $leaf->id]);
});

test('every weapon still says whether it can be crafted', function (): void {
    $root = ($this->weapon)('mineral');
    ($this->weapon)('Rathalos', $root, 2);

    $tree = create_weapon_tree($this->type, $this->hunter);

    // Dynamic Eloquent attributes are not real properties, so the value is what
    // there is to assert on.
    expect($tree->first()['root']->can_craft)->toBeBool()
        ->and($tree->first()['paths']->first()['weapons']->first()->can_craft)->toBeBool();
});
