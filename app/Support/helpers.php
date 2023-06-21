<?php

use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Support\Collection;

if (!function_exists('arr_expand')) {
    function arr_expand(&$data): void
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $e = explode('.', $k);
                $a = array_shift($e);

                if (1 === count($e)) {
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

if (!function_exists('create_weapon_tree')) {
    function create_weapon_tree(WeaponType $weaponType): Collection
    {
        $latestWeaponModels = $weaponType->weapons()
            ->doesntHave('children')
            ->with([
                'parent',
                'parent.parent',
                'parent.parent.parent',
                'parent.parent.parent.parent',
            ])
            ->get();

        $latestWeapons = collect();
        $latestWeaponModels->each(function (Weapon $weapon) use (&$latestWeapons): void {
            $weapons = collect();
            $branch = $weapon->branch;
            $rarity = $weapon->rarity;

            do {
                while ($rarity > $weapon->rarity) {
                    $weapons->push([]);
                    --$rarity;
                }
                $weapons->push($weapon);
                $weapon = $weapon->parent;
                --$rarity;
            } while (null !== $weapon);

            $latestWeapons->put($branch, $weapons->reverse()->values());
        });

        return $latestWeapons;
    }
}
