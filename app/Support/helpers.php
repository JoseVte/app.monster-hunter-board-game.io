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
    /**
     * Every weapon type has the same shape: two starting weapons, each opening
     * three to six paths, none longer than two more steps. The old return
     * grouped by branch, which repeated the starting weapon under every monster
     * that grows out of it, so one screen showed Buster Sword five times.
     *
     * This returns each root once with its paths hanging off it. Every weapon
     * carries `path_ids`, the way back to its root, which is what lets hovering
     * a card light the line that made it without the browser walking parents.
     *
     * @return Collection<int, array{root: Weapon, paths: Collection<int, array{branches: list<string>, weapons: Collection<int, Weapon>}>}>
     */
    function create_weapon_tree(WeaponType $weaponType, Hunter $hunter): Collection
    {
        $weapons = $weaponType->weapons()
            ->with(['recipes.items', 'parent'])
            ->get();

        $weapons->each(function (Weapon $weapon) use ($hunter, $weapons): void {
            $weapon->equipped = $hunter->equippedWeapons->firstWhere('id', $weapon->id);
            $weapon->craftable_recipes = $hunter->craftableRecipes($weapon)->pluck('id');
            $weapon->can_craft = $weapon->craftable_recipes->isNotEmpty();
            $weapon->path_ids = weapon_path_ids($weapon, $weapons);
        });

        $children = $weapons->groupBy('parent_id');

        return $weapons->whereNull('parent_id')->values()->map(fn (Weapon $root): array => [
            'root' => $root,
            'paths' => weapon_paths_from($root, $children),
        ]);
    }
}

if (! function_exists('weapon_path_ids')) {
    /**
     * @param  Collection<int, Weapon>  $weapons
     * @return list<int>
     */
    function weapon_path_ids(Weapon $weapon, Collection $weapons): array
    {
        $ids = [$weapon->id];
        $current = $weapon;

        while ($current->parent_id) {
            $current = $weapons->firstWhere('id', $current->parent_id);

            if (! $current) {
                break;
            }

            array_unshift($ids, $current->id);
        }

        return $ids;
    }
}

if (! function_exists('weapon_paths_from')) {
    /**
     * One entry per way out of this root, each already ordered from the root
     * outwards and labelled with the branches its recipes belong to. A weapon
     * two monsters both build appears once, carrying both names.
     *
     * @param  Collection<int, Collection<int, Weapon>>  $children
     * @return Collection<int, array{branches: list<string>, weapons: Collection<int, Weapon>}>
     */
    function weapon_paths_from(Weapon $root, Collection $children): Collection
    {
        return collect($children->get($root->id, collect()))
            ->map(function (Weapon $first) use ($children): array {
                $line = collect([$first]);
                $current = $first;

                while ($next = collect($children->get($current->id, collect()))->first()) {
                    $line->push($next);
                    $current = $next;
                }

                return [
                    'branches' => $line->flatMap(
                        fn (Weapon $weapon) => $weapon->recipes->pluck('branch')
                    )->filter()->unique()->values()->all(),
                    'weapons' => $line,
                ];
            })
            ->values();
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
