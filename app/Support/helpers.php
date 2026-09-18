<?php

use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Support\Collection;

if (! function_exists('arr_expand')) {
    function arr_expand(&$data): void
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $e = explode('.', $k);
                $a = array_shift($e);

                if (count($e) === 1) {
                    $data[$a][$e[0]] = $v;
                } elseif (count($e) > 1) {
                    $data[$a][implode('.', $e)] = $v;
                }
            }

            foreach ($data as $k => $v) {
                arr_expand($data[$k]);

                if (str_contains($k, '.')) {
                    unset($data[$k]);
                }
            }
        }
    }
}

if (! function_exists('create_weapon_tree')) {
    function create_weapon_tree(WeaponType $weaponType, Hunter $hunter): Collection
    {
        $latestWeaponModels = $weaponType->weapons()
            ->doesntHave('children')
            ->with([
                'recipes.items',
                'parent',
                'parent.recipes.items',
                'parent.parent',
                'parent.parent.recipes.items',
                'parent.parent.parent',
                'parent.parent.parent.recipes.items',
                'parent.parent.parent.parent',
                'parent.parent.parent.parent.recipes.items',
            ])
            ->get();

        $latestWeapons = collect();
        $latestWeaponModels->each(function (Weapon $leaf) use ($hunter, &$latestWeapons): void {
            $weapons = collect();
            $weapon = $leaf;
            $rarity = $weapon->rarity;

            do {
                $weapon->equipped = $hunter->equippedWeapons->firstWhere('id', $weapon->id);
                $weapon->craftable_recipes = $hunter->craftableRecipes($weapon)->pluck('id');
                $weapon->can_craft = $weapon->craftable_recipes->isNotEmpty();

                while ($rarity > $weapon->rarity) {
                    $weapons->push([]);
                    $rarity--;
                }
                $weapons->push($weapon);
                $weapon = $weapon->parent;
                $rarity--;
            } while ($weapon !== null);

            $line = $weapons->reverse()->values();

            // A line reachable from two monsters is listed under both, because a
            // player coming down either tree has to be able to find it.
            $leaf->recipes->pluck('branch')->filter()->unique()->each(
                fn (string $branch) => $latestWeapons->put($branch, $line)
            );
        });

        return $latestWeapons;
    }
}

if (! function_exists('achievement_progress')) {
    function achievement_progress(int $achieved, ?int $target): int
    {
        if (! $target) {
            return 0;
        }

        return (int) min($achieved / $target * 100, 100);
    }
}
