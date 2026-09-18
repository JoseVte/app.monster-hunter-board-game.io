<?php

use App\Enum\MonsterExpansion;
use Database\Seeders\SeedData;

/**
 * The seed data holds around 1600 references that are plain strings matching
 * other plain strings: a weapon names its parent, its materials and the monster
 * it branches from, an armour names its materials and its skill, a monster names
 * what it drops. Nothing enforces any of that until a seeder runs against a
 * database and fails somewhere unhelpful, so these walk every reference instead.
 */
const WEAPON_TYPES = [
    'great-sword', 'sword-shield', 'dual-blades', 'longsword', 'hammer',
    'hunting-horn', 'lance', 'gunlance', 'switch-axe', 'charge-blade',
    'insect-glaive', 'bow', 'light-bowgun', 'heavy-bowgun',
];

// Weapons and armours branch from a monster, or from one of the two material
// families that belong to no monster at all.
const MATERIAL_BRANCHES = ['mineral', 'bone'];

function itemNames(): array
{
    return collect(SeedData::get('items'))
        ->flatMap(fn (array $items): array => array_keys($items))
        ->all();
}

function monsterNames(): array
{
    return array_keys(SeedData::get('monsters'));
}

function weaponsByType(): array
{
    return collect(WEAPON_TYPES)
        ->mapWithKeys(fn (string $type): array => [$type => SeedData::get("weapons/$type")['weapons'] ?? []])
        ->all();
}

/**
 * A weapon is normally crafted one way, from one monster's parts. Two of them can
 * be built from either of two monsters, so `branch` becomes a list and `items` a
 * list of material sets, paired by position. Everything downstream reads through
 * this rather than branching on the shape.
 *
 * @return list<array{branch: string|null, items: array<string, int>}>
 */
function recipesOf(array $weapon): array
{
    $branches = (array) ($weapon['branch'] ?? [null]);
    $items = $weapon['items'] ?? [];
    $sets = $items !== [] && array_is_list($items) && is_array(reset($items)) ? $items : [$items];

    return collect($branches)
        ->map(fn (?string $branch, int $index): array => [
            'branch' => $branch,
            'items' => $sets[$index] ?? $sets[0] ?? [],
        ])
        ->all();
}

function armorsBySlot(): array
{
    return collect(['HEAD', 'BODY', 'LEG'])
        ->mapWithKeys(fn (string $slot): array => [$slot => SeedData::get("armors.$slot")])
        ->all();
}

test('every weapon upgrades from a weapon of its own type', function (): void {
    $dangling = [];

    foreach (weaponsByType() as $type => $weapons) {
        $names = array_keys($weapons);

        foreach ($weapons as $name => $weapon) {
            $parent = $weapon['parent'] ?? null;

            if ($parent !== null && ! in_array($parent, $names, true)) {
                $dangling[] = "$type: $name -> $parent";
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('every weapon material is a real item', function (): void {
    $items = itemNames();
    $dangling = [];

    foreach (weaponsByType() as $type => $weapons) {
        foreach ($weapons as $name => $weapon) {
            foreach (recipesOf($weapon) as $recipe) {
                foreach (array_keys($recipe['items']) as $item) {
                    if (! in_array($item, $items, true)) {
                        $dangling[] = "$type: $name -> $item";
                    }
                }
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('every weapon branches from a monster or a material family', function (): void {
    $known = array_merge(monsterNames(), MATERIAL_BRANCHES);
    $dangling = [];

    foreach (weaponsByType() as $type => $weapons) {
        foreach ($weapons as $name => $weapon) {
            foreach ((array) ($weapon['branch'] ?? []) as $branch) {
                if (! in_array($branch, $known, true)) {
                    $dangling[] = "$type: $name -> $branch";
                }
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('no two weapons share a name, in either language', function (): void {
    $english = $spanish = [];

    foreach (weaponsByType() as $weapons) {
        foreach ($weapons as $name => $weapon) {
            $english[] = $name;
            $spanish[] = $weapon['name'];
        }
    }

    expect(array_keys(array_filter(array_count_values($english), fn (int $n): bool => $n > 1)))->toBeEmpty()
        ->and(array_keys(array_filter(array_count_values($spanish), fn (int $n): bool => $n > 1)))->toBeEmpty();
});

test('every weapon is named in Spanish', function (): void {
    // The English name is the key, so it cannot go missing without the entry
    // going with it. Only the Spanish one can.
    $incomplete = [];

    foreach (weaponsByType() as $type => $weapons) {
        foreach ($weapons as $name => $weapon) {
            if (empty($weapon['name'])) {
                $incomplete[] = "$type: $name";
            }
        }
    }

    expect($incomplete)->toBeEmpty();
});

test('every armour material is a real item', function (): void {
    $items = itemNames();
    $dangling = [];

    foreach (armorsBySlot() as $slot => $armors) {
        foreach ($armors as $name => $armor) {
            foreach (array_keys($armor['items'] ?? []) as $item) {
                if (! in_array($item, $items, true)) {
                    $dangling[] = "$slot: $name -> $item";
                }
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('every armour skill is a real skill', function (): void {
    $skills = collect(SeedData::get('armors.skills'))->pluck('name.en')->all();
    $dangling = [];

    foreach (armorsBySlot() as $slot => $armors) {
        foreach ($armors as $name => $armor) {
            $skill = $armor['skill'] ?? null;

            if ($skill !== null && ! in_array($skill, $skills, true)) {
                $dangling[] = "$slot: $name -> $skill";
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('every armour branches from a monster or a material family', function (): void {
    $known = array_merge(monsterNames(), MATERIAL_BRANCHES);
    $dangling = [];

    foreach (armorsBySlot() as $slot => $armors) {
        foreach ($armors as $name => $armor) {
            $branch = $armor['branch'] ?? null;

            if ($branch !== null && ! in_array($branch, $known, true)) {
                $dangling[] = "$slot: $name -> $branch";
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('every armour is named in Spanish', function (): void {
    $incomplete = [];

    foreach (armorsBySlot() as $slot => $armors) {
        foreach ($armors as $name => $armor) {
            if (empty($armor['name'])) {
                $incomplete[] = "$slot: $name";
            }
        }
    }

    expect($incomplete)->toBeEmpty();
});

test('every monster drop is a real item', function (): void {
    $items = itemNames();
    $dangling = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        foreach ($details['items'] ?? [] as $item) {
            if (! in_array($item, $items, true)) {
                $dangling[] = "$monster -> $item";
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('a monster only declares a Spanish name when it differs', function (): void {
    // Most are proper nouns that do not translate, so an absent name is correct
    // and the seeder falls back to the English key. What would be a mistake is
    // declaring one that simply repeats it.
    $redundant = collect(SeedData::get('monsters'))
        ->filter(fn (array $details, string $monster): bool => ($details['name'] ?? null) === $monster)
        ->keys()
        ->all();

    expect($redundant)->toBeEmpty();
});

test('no two items share a name, in either language', function (): void {
    $english = itemNames();
    $spanish = collect(SeedData::get('items'))->flatMap(fn (array $items): array => array_values($items))->all();

    expect(array_keys(array_filter(array_count_values($english), fn (int $n): bool => $n > 1)))->toBeEmpty()
        ->and(array_keys(array_filter(array_count_values($spanish), fn (int $n): bool => $n > 1)))->toBeEmpty();
});

test('a weapon parent is never resolved across types', function (): void {
    // Names are reused between types on purpose, so an unscoped parent lookup
    // would silently bind to another type's tree. WeaponsSeeder scopes it; this
    // records which names would be ambiguous if that ever changed.
    $counts = [];

    foreach (weaponsByType() as $weapons) {
        foreach (array_keys($weapons) as $name) {
            $counts[$name] = ($counts[$name] ?? 0) + 1;
        }
    }

    expect(array_sum($counts))->toEqual(284);
});

test('no more armour skills are left without a description', function (): void {
    // These five reached the screen with a blank description, and each one is
    // attached to an armour, so a player does see the gap. Listing them keeps
    // the count from growing while the text is written.
    $known = ['Maximum Might', 'Agitator', 'Nergigante Hunger'];

    $blank = collect(SeedData::get('armors.skills'))
        ->filter(fn (array $skill): bool => empty($skill['description']['en']) && empty($skill['description']['es']))
        ->pluck('name.en')
        ->all();

    expect(array_diff($blank, $known))->toBeEmpty();
});

test('every armour skill that has a description has it in both languages', function (): void {
    $halfDone = collect(SeedData::get('armors.skills'))
        ->filter(function (array $skill): bool {
            $english = $skill['description']['en'] ?? '';
            $spanish = $skill['description']['es'] ?? '';

            return ($english === '') !== ($spanish === '');
        })
        ->pluck('name.en')
        ->all();

    expect($halfDone)->toBeEmpty();
});

test('a weapon with several branches has a recipe for each', function (): void {
    $mismatched = [];

    foreach (weaponsByType() as $type => $weapons) {
        foreach ($weapons as $name => $weapon) {
            if (! is_array($weapon['branch'] ?? null)) {
                continue;
            }

            $sets = $weapon['items'] ?? [];

            if (count($sets) !== count($weapon['branch']) || ! array_is_list($sets)) {
                $mismatched[] = "$type: $name";
            }
        }
    }

    expect($mismatched)->toBeEmpty();
});

test('an armour declares the expansion of the monster it branches from', function (): void {
    // The two material families belong to no monster, so like the starting
    // weapons they are base game and carry no expansion at all.
    $expansions = collect(SeedData::get('monsters'))
        ->map(fn (array $monster) => $monster['expansion'])
        ->all();

    $wrong = [];

    foreach (armorsBySlot() as $slot => $armors) {
        foreach ($armors as $name => $armor) {
            $branch = $armor['branch'] ?? null;
            $declared = $armor['expansion'] ?? null;
            $expected = $expansions[$branch] ?? null;

            if ($declared !== $expected) {
                $wrong[] = "$slot: $name -> ".($declared?->name ?? 'none').' instead of '.($expected?->name ?? 'none');
            }
        }
    }

    expect($wrong)->toBeEmpty();
});

test('a weapon under an expansion section declares that expansion', function (): void {
    // Everything before the first section comment is generic to every box, so it
    // has no expansion. A section marked <NONE> contributes no weapons at all.
    $sections = [
        'ANCIENT FOREST' => 'ANCIENT_FOREST',
        'WILDSPIRE WASTE' => 'WILDSPIRE_WASTE',
        'KULU YA KU EXPANSION' => 'KULU_YA_KU_EXPANSION',
        'TEOSTRA EXPANSION' => 'TEOSTRA_EXPANSION',
        'NERGIGANTE EXPANSION' => 'NERGIGANTE_EXPANSION',
        'KUSHALA EXPANSION' => 'KUSHALA_EXPANSION',
        'KIRIN EXPANSION' => 'KIRIN_EXPANSION',
    ];

    $wrong = [];

    foreach (WEAPON_TYPES as $type) {
        $section = null;

        foreach (file(database_path("seeders/data/weapons/$type.php")) as $line) {
            if (preg_match('/^\s*\/\/ ([A-Z][A-Z ]*?)(\s*<[A-Z]+>)?\s*$/', $line, $m)) {
                $section = trim($m[1]);

                continue;
            }

            if (! preg_match("/^        '(.+?)' => \[$/", rtrim($line), $entry)) {
                continue;
            }

            $weapon = SeedData::get("weapons/$type")['weapons'][stripslashes($entry[1])] ?? null;
            $declared = $weapon['expansion'] ?? null;
            // MonsterExpansion is a pure enum, so casting one to an array hands
            // back its properties rather than a single element list.
            $names = collect(is_array($declared) ? $declared : array_filter([$declared]))
                ->map(fn (MonsterExpansion $expansion): string => $expansion->name)
                ->all();

            if ($section === null && $declared !== null) {
                $wrong[] = "$type: {$entry[1]} is generic but declares ".implode('+', $names);
            }

            if ($section !== null && ! in_array($sections[$section] ?? null, $names, true)) {
                $wrong[] = "$type: {$entry[1]} sits under $section but declares ".(implode('+', $names) ?: 'ninguna');
            }
        }
    }

    expect($wrong)->toBeEmpty();
});

test('every monster reward is a real item', function (): void {
    $items = itemNames();
    $dangling = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        foreach ($details['rewards'] ?? [] as $roll => $reward) {
            if (! in_array($reward['name'], $items, true)) {
                $dangling[] = "$monster: roll $roll -> {$reward['name']}";
            }
        }
    }

    expect($dangling)->toBeEmpty();
});

test('every monster reward table has all twelve rolls', function (): void {
    $wrong = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        $rolls = array_keys($details['rewards'] ?? []);
        sort($rolls);

        if ($rolls !== range(1, 12)) {
            $wrong[] = $monster;
        }
    }

    expect($wrong)->toBeEmpty();
});

test('every monster difficulty tier has at least one body part', function (): void {
    $incomplete = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        foreach ($details['difficulty'] ?? [] as $tier) {
            if (empty($tier['parts'])) {
                $incomplete[] = "$monster: {$tier['difficulty']->name}";
            }
        }
    }

    expect($incomplete)->toBeEmpty();
});

test('every body part direction is one of a known set', function (): void {
    // Show.vue maps each of these to an arrow glyph. A new value here would
    // silently render blank rather than failing loudly.
    $known = ['up', 'down', 'left', 'right', 'left-right', 'left-right-down', 'up-left-right'];
    $unknown = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        foreach ($details['difficulty'] ?? [] as $tier) {
            foreach ($tier['parts'] ?? [] as $part) {
                if (! in_array($part['direction'], $known, true)) {
                    $unknown[] = "$monster: {$tier['difficulty']->name} -> {$part['icon']} -> {$part['direction']}";
                }
            }
        }
    }

    expect($unknown)->toBeEmpty();
});

test('every monster resistance declares exactly the ten known elements', function (): void {
    $known = [
        'fire', 'water', 'thunder', 'ice', 'dragon',
        'paralysis', 'poison', 'sleep', 'nitro', 'stun',
    ];
    $wrong = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        $keys = array_keys($details['resistance'] ?? []);
        sort($keys);
        $sortedKnown = $known;
        sort($sortedKnown);

        if ($keys !== $sortedKnown) {
            $wrong[] = $monster;
        }
    }

    expect($wrong)->toBeEmpty();
});

test('every monster mechanics section is shaped bilingually', function (): void {
    // Monster::localizeMechanics() walks this structure with no guards and
    // would throw a TypeError on a malformed entry.
    $isBilingual = fn ($value): bool => is_array($value) && array_key_exists('en', $value) && array_key_exists('es', $value);
    $malformed = [];

    foreach (SeedData::get('monsters') as $monster => $details) {
        foreach ($details['mechanics'] ?? [] as $section) {
            if (! $isBilingual($section['title'] ?? null)) {
                $malformed[] = "$monster: section title";

                continue;
            }

            foreach ($section['description'] ?? [] as $item) {
                if (! $isBilingual($item['title'] ?? null)) {
                    $malformed[] = "$monster: {$section['title']['en']} -> item title";
                }

                if (! $isBilingual($item['description'] ?? null)) {
                    $malformed[] = "$monster: {$section['title']['en']} -> item description";
                }
            }
        }
    }

    expect($malformed)->toBeEmpty();
});
