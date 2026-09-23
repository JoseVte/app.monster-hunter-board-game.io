// Typed on purpose. When a model gains or loses a column, this file stops
// compiling, which is how the fixture stays honest about what a page receives.
// Every non-optional property is filled; `npm run typecheck` names whichever
// one is missing, so that is how this file was built, not by reading the
// schema top to bottom.
//
// A few fields carry data that is not part of the plain model (a pivot's
// `number`, or the extra keys the wiki controllers bolt onto a weapon before
// handing it to a page). Those are built as a separate variable and spread in,
// rather than written as an object literal in place, so TypeScript's excess
// property check does not fire on a fixture that is deliberately wider than
// its declared type.

export const item: App.Models.Item = {
    id: 1,
    type: 'MONSTER_PART',
    name: 'Anjanath Scale',
    created_at: '2026-01-01T00:00:00.000000Z',
    updated_at: '2026-01-01T00:00:00.000000Z',
    icon_path: null,
    icon_url: '/images/items/anjanath-scale.png',
    monsters: [],
    weapons: [],
    armors: [],
};

export const weaponType: App.Models.WeaponType = {
    id: 1,
    name: 'Great Sword',
    description: 'A slow weapon that hits hardest fully charged.',
    image_path: null,
    default_armor: null,
    created_at: '2026-01-01T00:00:00.000000Z',
    updated_at: '2026-01-01T00:00:00.000000Z',
    image_url: '/images/weapon-types/great-sword.svg',
    weapons: [],
    song_lists: [],
};

const weaponRecipeItem = {...item, pivot: {number: 3}};

export const weapon: App.Models.Weapon = {
    id: 1,
    type_id: 1,
    parent_id: null,
    name: 'Iron Sword',
    // `false`, deliberately: `Wiki/Partials/CraftWithHunter.vue` gates its
    // entire template on `! (weapon?.is_default || armor?.is_default)`, and
    // the smoke test hands every mount both `weapon` and `armor` from this
    // file at once. `true` here made that component (and its craft controls,
    // reached transitively through `Weapon/Detail.vue`) render `<!--v-if-->`
    // and nothing else, passing both of the smoke test's assertions while
    // exercising none of its template. `armor.is_default` has to stay `false`
    // for the same reason.
    is_default: false,
    rarity: 1,
    defense: 0,
    count_attack_1: 2,
    count_attack_2: 1,
    count_attack_3: 0,
    count_attack_4: 0,
    count_attack_5: 0,
    has_elemental_attacks: false,
    element: null,
    status_attacks: [],
    deviation: null,
    song_list_id: null,
    created_at: '2026-01-01T00:00:00.000000Z',
    updated_at: '2026-01-01T00:00:00.000000Z',
    deviation_key: null,
    type: weaponType,
    recipes: [
        {
            id: 1,
            weapon_id: 1,
            branch: 'Anjanath',
            branch_id: null,
            // Raw enum key, correctly: unlike `Armor` below, `WeaponRecipe`
            // does not run through `HasTranslations`, so its own `expansion`
            // column is never flattened to a translated label. `Weapon/
            // Detail.vue` uses this raw value as a filter query parameter and
            // prints the separate `expansion_label` instead.
            expansion: 'CORE_BOX',
            position: 1,
            created_at: '2026-01-01T00:00:00.000000Z',
            updated_at: '2026-01-01T00:00:00.000000Z',
            expansion_label: 'Core Box',
            items: [weaponRecipeItem],
        },
    ],
    items: [],
    attacks_to_add: [],
    attacks_to_remove: [],
};

export const monster: App.Models.Monster = {
    id: 1,
    name: 'Anjanath',
    description: 'A brute wyvern that hits hard and burns the ground it stands on.',
    category: 'Brute Wyvern',
    expansion: 'Core Box',
    created_at: '2026-01-01T00:00:00.000000Z',
    updated_at: '2026-01-01T00:00:00.000000Z',
    resistance_fire: 3,
    resistance_water: null,
    resistance_thunder: null,
    resistance_ice: null,
    resistance_dragon: null,
    resistance_paralysis: 1,
    resistance_poison: null,
    resistance_sleep: null,
    resistance_nitro: null,
    resistance_stun: null,
    setup: 'Place three shrieker traps around the arena before the hunt begins.',
    mechanics: [
        {
            title: 'Rage Mode',
            description: [
                {title: 'Trigger', description: 'Becomes enraged once reduced to half health.'},
            ],
        },
    ],
    icon_path: null,
    icon_url: '/images/monsters/anjanath.png',
    items: [item],
    difficulties: [
        {
            id: 1,
            monster_id: 1,
            difficulty: 'NORMAL',
            stars: 3,
            health: 250,
            ability_name: 'Roar',
            ability_description: 'Fear every hunter within range.',
            created_at: '2026-01-01T00:00:00.000000Z',
            updated_at: '2026-01-01T00:00:00.000000Z',
            parts: [
                {
                    id: 1,
                    monster_difficulty_id: 1,
                    icon: 'head',
                    direction: 'up',
                    defense: 20,
                    broken: 2,
                    ability_broken: 'Loses the ability to roar.',
                    position: 1,
                    created_at: '2026-01-01T00:00:00.000000Z',
                    updated_at: '2026-01-01T00:00:00.000000Z',
                },
                {
                    id: 2,
                    monster_difficulty_id: 1,
                    icon: 'tail',
                    direction: 'left-right',
                    defense: 15,
                    broken: 1,
                    ability_broken: null,
                    position: 2,
                    created_at: '2026-01-01T00:00:00.000000Z',
                    updated_at: '2026-01-01T00:00:00.000000Z',
                },
                {
                    id: 3,
                    monster_difficulty_id: 1,
                    icon: 'back',
                    direction: 'up',
                    defense: 18,
                    broken: 1,
                    ability_broken: null,
                    position: 3,
                    created_at: '2026-01-01T00:00:00.000000Z',
                    updated_at: '2026-01-01T00:00:00.000000Z',
                },
            ],
        },
    ],
    rewards: [
        {
            id: 1,
            monster_id: 1,
            roll: 1,
            item_id: 1,
            extra: null,
            created_at: '2026-01-01T00:00:00.000000Z',
            updated_at: '2026-01-01T00:00:00.000000Z',
            item,
        },
    ],
};

const armorItem = {...item, pivot: {number: 2}};

export const armor: App.Models.Armor = {
    id: 1,
    type: 'HEAD',
    name: 'Anjanath Helm',
    is_default: false,
    branch_id: null,
    // The translated label, not the raw enum key: `Armor::expansion` is cast
    // through `MonsterExpansion` (a `TranslatableEnum`), so
    // `HasTranslations::toArray()` flattens it down to this before it ever
    // reaches a page. The raw key lives on `expansion_value` below instead,
    // which is exactly why that accessor exists (see its docblock in
    // `app/Models/Armor.php`).
    expansion: 'Ancient Forest',
    branch: 'Anjanath',
    rarity: 3,
    defense: 10,
    defense_fire: 2,
    defense_water: 0,
    defense_thunder: 0,
    defense_ice: 0,
    defense_dragon: 0,
    created_at: '2026-01-01T00:00:00.000000Z',
    updated_at: '2026-01-01T00:00:00.000000Z',
    type_value: 'head',
    expansion_value: 'ANCIENT_FOREST',
    skills: [
        {
            id: 1,
            name: 'Fire Resistance',
            description: 'Reduces fire damage taken.',
            bonus_set: true,
            bonus_set_armor: null,
            created_at: '2026-01-01T00:00:00.000000Z',
            updated_at: '2026-01-01T00:00:00.000000Z',
        },
    ],
    items: [armorItem],
};

export const hunter: App.Models.Hunter = {
    id: 1,
    campaign_id: 1,
    weapon_type_id: 1,
    name: 'Rook',
    created_at: '2026-01-01T00:00:00.000000Z',
    updated_at: '2026-01-01T00:00:00.000000Z',
};
