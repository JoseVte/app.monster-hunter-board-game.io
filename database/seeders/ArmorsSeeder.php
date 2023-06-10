<?php

namespace Database\Seeders;

use Arr;
use App\Models\Item;
use App\Models\Armor;
use App\Enum\ArmorType;
use App\Models\ArmorAbility;
use Illuminate\Database\Seeder;

class ArmorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ArmorType::cases() as $type) {
            foreach (config('seeders.armors.'.$type->name) as $armorName => $armorDetails) {
                $armor = Armor::create([
                    'type' => $type,
                    'name' => $armorName,
                    'defense' => Arr::get($armorDetails, 'defense', 0),
                    'defense_fire' => Arr::get($armorDetails, 'defense_fire', 0),
                    'defense_water' => Arr::get($armorDetails, 'defense_water', 0),
                    'defense_ice' => Arr::get($armorDetails, 'defense_ice', 0),
                    'defense_thunder' => Arr::get($armorDetails, 'defense_thunder', 0),
                    'defense_dragon' => Arr::get($armorDetails, 'defense_dragon', 0),
                ]);
                if (Arr::get($armorDetails, 'ability')) {
                    if (ArmorAbility::where('name->en', $armorDetails['ability'])->doesntExist()) {
                        logger('Armor ability: '.$armorDetails['ability']);
                    }

                    $ability = ArmorAbility::where('name->en', $armorDetails['ability'])->firstOrFail();
                    $armor->abilities()->attach($ability);
                }
                if (Arr::get($armorDetails, 'items')) {
                    foreach ($armorDetails['items'] as $itemName => $count) {
                        if (Item::where('name->en', $itemName)->doesntExist()) {
                            logger('Item: '.$itemName);
                        }

                        $item = Item::where('name->en', $itemName)->firstOrFail();
                        $armor->items()->attach($item, ['number' => $count]);
                    }
                }
            }
        }
    }
}
