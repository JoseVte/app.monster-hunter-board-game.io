<?php

namespace Database\Seeders;

use Arr;
use Str;
use App\Models\Item;
use App\Models\Monster;
use App\Models\MonsterPart;
use App\Models\MonsterReward;
use Illuminate\Database\Seeder;
use App\Models\MonsterDifficulty;
use Illuminate\Support\Facades\Storage;

class MonstersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storage = Storage::disk(config('jetstream.profile_photo_disk', 'public'));

        foreach (SeedData::get('monsters') as $monster => $details) {
            $resistance = Arr::get($details, 'resistance', []);
            $iconFile = resource_path('images/monsters/'.Str::slug($monster).'.png');

            $record = Monster::updateOrCreate(
                ['name->en' => $monster],
                [
                    'name' => [
                        'en' => $monster,
                        'es' => $details['name'] ?? $monster,
                    ],
                    'category' => $details['category'],
                    'expansion' => $details['expansion'],
                    'resistance_fire' => Arr::get($resistance, 'fire'),
                    'resistance_water' => Arr::get($resistance, 'water'),
                    'resistance_thunder' => Arr::get($resistance, 'thunder'),
                    'resistance_ice' => Arr::get($resistance, 'ice'),
                    'resistance_dragon' => Arr::get($resistance, 'dragon'),
                    'resistance_paralysis' => Arr::get($resistance, 'paralysis'),
                    'resistance_poison' => Arr::get($resistance, 'poison'),
                    'resistance_sleep' => Arr::get($resistance, 'sleep'),
                    'resistance_nitro' => Arr::get($resistance, 'nitro'),
                    'resistance_stun' => Arr::get($resistance, 'stun'),
                    'setup' => Arr::get($details, 'setup', []),
                    'mechanics' => Arr::get($details, 'mechanics', []),
                    'icon_path' => is_file($iconFile)
                        ? $storage->putFileAs('monsters', $iconFile, Str::slug($monster).'.png', 'public')
                        : null,
                ],
            );

            // What it drops. Synced rather than attached so seeding twice does
            // not double the links, and so a part removed from the data goes.
            $record->items()->sync(
                Item::whereIn('name->en', $details['items'] ?? [])->pluck('id'),
            );

            $this->syncDifficulties($record, Arr::get($details, 'difficulty', []));
            $this->syncRewards($record, Arr::get($details, 'rewards', []));
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $difficulties
     */
    private function syncDifficulties(Monster $monster, array $difficulties): void
    {
        foreach ($difficulties as $tier) {
            $record = MonsterDifficulty::updateOrCreate(
                [
                    'monster_id' => $monster->id,
                    'difficulty' => $tier['difficulty']->name,
                ],
                [
                    'stars' => $tier['stars'],
                    'health' => $tier['health'],
                    'ability_name' => $tier['ability']['name'],
                    'ability_description' => $tier['ability']['description'],
                ],
            );

            // Parts are positional rather than named, so reseeding replaces
            // them wholesale instead of trying to match old rows to new ones.
            $record->parts()->delete();

            foreach ($tier['parts'] ?? [] as $position => $part) {
                MonsterPart::create([
                    'monster_difficulty_id' => $record->id,
                    'icon' => $part['icon'],
                    'direction' => $part['direction'],
                    'defense' => $part['defense'],
                    'broken' => $part['broken'],
                    'ability_broken' => Arr::get($part, 'ability-broken', []),
                    'position' => $position,
                ]);
            }
        }

        // A tier removed from the data leaves a row behind, which would keep
        // offering a difficulty the monster no longer has.
        $monster->difficulties()->whereNotIn(
            'difficulty',
            collect($difficulties)->pluck('difficulty.name')->all(),
        )->delete();
    }

    /**
     * @param  array<int, array<string, mixed>>  $rewards
     */
    private function syncRewards(Monster $monster, array $rewards): void
    {
        foreach ($rewards as $roll => $reward) {
            $item = Item::where('name->en', $reward['name'])->firstOrFail();

            MonsterReward::updateOrCreate(
                ['monster_id' => $monster->id, 'roll' => $roll],
                ['item_id' => $item->id, 'extra' => Arr::get($reward, 'extra', [])],
            );
        }
    }
}
