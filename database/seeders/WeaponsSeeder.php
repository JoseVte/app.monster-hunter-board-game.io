<?php

namespace Database\Seeders;

use Arr;
use Str;
use App\Models\Item;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\WeaponType;
use App\Models\WeaponAttack;
use App\Models\WeaponRecipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WeaponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storage = Storage::disk(config('jetstream.profile_photo_disk', 'public'));

        $weaponTypes = [
            'great-sword',
            'sword-shield',
            'dual-blades',
            'longsword',
            'hammer',
            'hunting-horn',
            'lance',
            'gunlance',
            'switch-axe',
            'charge-blade',
            'insect-glaive',
            'bow',
            'light-bowgun',
            'heavy-bowgun',
        ];

        foreach ($weaponTypes as $weaponsByType) {
            $weaponsByType = SeedData::get('weapons/'.$weaponsByType);

            if (! empty($weaponsByType)) {
                $weaponType = WeaponType::updateOrCreate(['name->en' => $weaponsByType['name']['en']], [
                    'name' => $weaponsByType['name'],
                    'description' => Arr::get($weaponsByType, 'description'),
                    'image_path' => $storage->putFileAs(
                        'weapon-types',
                        resource_path('images/'.$weaponsByType['image']),
                        Str::slug($weaponsByType['name']['en']).'.'.pathinfo($weaponsByType['image'], PATHINFO_EXTENSION),
                        'public',
                    ),
                ]);

                foreach (Arr::get($weaponsByType, 'weapons', []) as $weaponName => $weaponDetails) {
                    $weapon = Weapon::updateOrCreate([
                        'name->en' => $weaponName,
                        'type_id' => $weaponType->id,
                    ], [
                        'name' => ['en' => $weaponName, 'es' => $weaponDetails['name']],
                        'type_id' => $weaponType->id,
                        'is_default' => Arr::get($weaponDetails, 'default', false),
                        'has_elemental_attacks' => Arr::get($weaponDetails, 'has_elemental_attacks', false),
                        'deviation' => Arr::get($weaponDetails, 'deviation'),
                        'rarity' => Arr::get($weaponDetails, 'rarity', 1),
                        'defense' => Arr::get($weaponDetails, 'defense', 0),
                        'count_attack_1' => Arr::get($weaponDetails, 'count_attack_1', 0),
                        'count_attack_2' => Arr::get($weaponDetails, 'count_attack_2', 0),
                        'count_attack_3' => Arr::get($weaponDetails, 'count_attack_3', 0),
                        'count_attack_4' => Arr::get($weaponDetails, 'count_attack_4', 0),
                        'count_attack_5' => Arr::get($weaponDetails, 'count_attack_5', 0),
                    ]);

                    if (Arr::get($weaponDetails, 'parent')) {
                        // Scoped to the weapon type on purpose: a weapon always upgrades from
                        // another weapon of its own type, and several names are reused across
                        // types, so an unscoped lookup would silently bind to the wrong tree.
                        $parent = Weapon::where('name->en', $weaponDetails['parent'])
                            ->where('type_id', $weaponType->id);

                        if ($parent->doesntExist()) {
                            logger('Weapon parent: '.$weaponDetails['parent']);
                        }

                        $weapon->parent_id = $parent->firstOrFail()->id;
                        $weapon->save();
                    }

                    $this->syncRecipes($weapon, $weaponDetails);

                    if (Arr::get($weaponDetails, 'attacks')) {
                        if (Arr::get($weaponDetails, 'attacks.remove')) {
                            foreach ($weaponDetails['attacks']['remove'] as $attackName => $count) {
                                if (WeaponAttack::where('name->en', $attackName)->doesntExist()) {
                                    logger('Attack name: '.$attackName);
                                    WeaponAttack::create(['name' => $attackName]);
                                }

                                $weaponAttack = WeaponAttack::where('name->en', $attackName)->firstOrFail();
                                $weapon->attacksToRemove()->syncWithoutDetaching([$weaponAttack->id => ['number' => $count]]);
                            }
                        }
                        if (Arr::get($weaponDetails, 'attacks.add')) {
                            foreach ($weaponDetails['attacks']['add'] as $attackName => $count) {
                                if (WeaponAttack::where('name->en', $attackName)->doesntExist()) {
                                    logger('Attack name: '.$attackName);
                                    WeaponAttack::create(['name' => $attackName]);
                                }

                                $weaponAttack = WeaponAttack::where('name->en', $attackName)->firstOrFail();
                                $weapon->attacksToAdd()->syncWithoutDetaching([$weaponAttack->id => ['number' => $count]]);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * A weapon is normally craftable one way. Two dual blades can be built from
     * either of two monsters at different prices, which the data writes as a list
     * of branches and a matching list of material sets, paired by position.
     *
     * @param  array<string, mixed>  $details
     */
    private function syncRecipes(Weapon $weapon, array $details): void
    {
        $branches = (array) Arr::get($details, 'branch', [null]);
        $sets = $this->materialSets($details);

        // The expansion pairs with the branch by position, the way the materials
        // do. A branch generic to every box declares none.
        $expansions = Arr::get($details, 'expansion');
        $expansions = is_array($expansions) ? $expansions : [$expansions];

        foreach ($branches as $position => $branch) {
            $recipe = WeaponRecipe::updateOrCreate([
                'weapon_id' => $weapon->id,
                'position' => $position,
            ], [
                'branch' => $branch,
                'branch_id' => $branch ? Monster::where('name->en', $branch)->value('id') : null,
                'expansion' => $expansions[$position] ?? $expansions[0] ?? null,
            ]);

            foreach ($sets[$position] ?? $sets[0] ?? [] as $itemName => $count) {
                $item = Item::where('name->en', $itemName)->first();

                if (! $item) {
                    logger('Item: '.$itemName);

                    continue;
                }

                $recipe->items()->syncWithoutDetaching([$item->id => ['number' => $count, 'weapon_id' => $weapon->id]]);
            }
        }

        // A branch removed from the data leaves a recipe behind, which would keep
        // offering a way to build the weapon that no longer exists.
        $weapon->recipes()->where('position', '>=', count($branches))->delete();
    }

    /**
     * @param  array<string, mixed>  $details
     * @return list<array<string, int>>
     */
    private function materialSets(array $details): array
    {
        $items = Arr::get($details, 'items', []);

        if ($items === [] || ! array_is_list($items)) {
            return [$items];
        }

        return $items;
    }
}
