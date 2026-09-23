import type {Component} from 'vue';
import {flushPromises} from '@vue/test-utils';
import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import * as fixtures from './fixtures';
import {mountComponent} from './setup';

// Every page and partial under Pages/Wiki. The 29 shared Components/ they use
// are mounted transitively as children, which is better coverage than mounting
// them standalone: it exercises the props the pages really pass them.
const components = import.meta.glob('/resources/js/Pages/Wiki/**/*.vue');

// `Wiki/Weapon/Show.vue` (and, transitively, `Hunter/Partials/ListWeapons.vue`)
// does not take a flat list of weapons: the controller builds one entry per
// root weapon, each carrying every buildable path out of it, and the tree
// component reduces over that shape (`entry.paths[].weapons[].rarity`, and so
// on). Passing the plain `fixtures.weapon` array here, the way every other
// page's `weapons` key wants it, throws inside `ListWeapons.vue` the moment it
// tries to read `entry.paths`. See `App\Support\helpers.php`'s
// `create_weapon_tree()` for the real shape this stands in for.
const weaponTree = [
    {
        root: fixtures.weapon,
        paths: [
            {branches: ['Anjanath'], weapons: [fixtures.weapon]},
        ],
    },
];

// `Wiki/Monster/Partials/MonsterPartBox.vue` is matched by the glob above (it
// lives under `Pages/Wiki`) and so gets mounted on its own as well as
// transitively through `Monster/Show.vue` and `Monster/Card.vue`. Standalone,
// it needs its own `part`, which none of the pages declare as a top-level prop.
const part = fixtures.monster.difficulties![0].parts![0];

// Every option list a `*Filters.vue` partial reads through `props.options`.
// Each is read with a bare `.map(...)`, so a key this leaves out throws before
// any of the four pages that pass filters even reach the DOM; the real shape
// comes from each Wiki controller's own `options()` method.
const options = {
    types: [{key: 'MONSTER_PART', label: 'Monster Part'}],
    categories: [{key: 'BRUTE_WYVERN', label: 'Brute Wyvern'}],
    expansions: [{key: 'ANCIENT_FOREST', label: 'Ancient Forest'}],
    rarities: [1, 2, 3, 4, 5],
    branches: [{key: 'Anjanath', label: 'Anjanath'}],
};

// `CraftWithHunter.vue` needs more than the plain `Hunter` model: the
// `craftable_recipes`/`can_craft`/`missing_by_recipe`/`owned`/`parent_owned`
// keys are computed per request by `WeaponController::hunters()` and
// `ArmorController::hunters()`, not columns on the model, which is why they
// are added here rather than in `fixtures.ts` (typed strictly against
// `App.Models.Hunter`, they would not compile there). Built from
// `fixtures.hunter` so `hunter` fixture stays exercised rather than merely
// exported for a later phase.
const hunterForCrafting = {
    ...fixtures.hunter,
    campaign: 'Iceborne Crew',
    campaign_id: fixtures.hunter.campaign_id,
    craftable_recipes: [],
    can_craft: false,
    missing_by_recipe: {},
    missing: [],
    owned: false,
    parent_owned: null,
};

// A prop a Wiki page or partial might be handed. Built by reading every one of
// the 16 files' `defineProps` rather than guessing: a page or partial ignores
// whatever it did not declare, so one bag covering the union is fine, but a
// prop missing from it is a mount failure away from being noticed.
const props = {
    monster: fixtures.monster,
    monsters: [fixtures.monster],
    weapon: fixtures.weapon,
    weapons: weaponTree,
    weaponType: fixtures.weaponType,
    weaponTypes: [fixtures.weaponType],
    matching: [fixtures.weapon.id],
    armor: fixtures.armor,
    branches: [] as unknown[],
    item: fixtures.item,
    items: [fixtures.item],
    hunters: [hunterForCrafting],
    part,
    filters: {},
    options,
    routeName: 'wiki.weapon.index',
};

let warnings: string[] = [];

beforeEach(() => {
    warnings = [];
    vi.spyOn(console, 'warn').mockImplementation((message: string) => {
        warnings.push(message);
    });
    vi.spyOn(console, 'error').mockImplementation((message: string) => {
        warnings.push(message);
    });
});

afterEach(() => {
    vi.restoreAllMocks();
});

describe('every Wiki component', () => {
    // A glob that matches nothing turns every it.each below into a pass, and
    // this repo has already shipped that exact failure once: a green typecheck
    // over 175 files that checked none of them. The count is asserted so the
    // suite cannot go green by covering nothing.
    it('is found by the glob', () => {
        expect(Object.keys(components).length).toBeGreaterThanOrEqual(16);
    });

    // The count above only catches total collapse: a page renamed out of the
    // glob's reach while an unrelated file is added elsewhere under
    // `Pages/Wiki/**` leaves the count at 16 (or higher) and hides the rename.
    // This is a sample of four, not the full sixteen, on purpose: `toBe(16)`
    // would fail every time a page is legitimately added, and a test that
    // cries wolf at every addition is the kind that gets deleted. Naming a
    // few of the richest pages catches a rename of something that matters
    // without punishing growth.
    it('includes the richest pages by name, not just by count', () => {
        const paths = Object.keys(components);

        for (const path of [
            '/resources/js/Pages/Wiki/Monster/Show.vue',
            '/resources/js/Pages/Wiki/Weapon/Detail.vue',
            '/resources/js/Pages/Wiki/Armor/Detail.vue',
            '/resources/js/Pages/Wiki/Item/Show.vue',
        ]) {
            expect(paths).toContain(path);
        }
    });

    it.each(Object.keys(components))('%s mounts and renders', async (path) => {
        const module = (await components[path]()) as {default: Component};

        const wrapper = mountComponent(module.default, props);

        // `flushPromises` (a macrotask, via `setTimeout(0)`) rather than a
        // bare `await nextTick()` (a microtask): a warning from an async
        // `onMounted` hook, or a rejection resolving on a later tick, would
        // otherwise run after these assertions and land in the *next* test's
        // `warnings` array, or vanish at `beforeEach`'s reset, either of
        // which quietly breaks the "fails on any warning" guarantee this
        // suite exists for. Nothing in today's 16 does this, but the harness
        // should not depend on that staying true.
        await flushPromises();

        expect(wrapper.html()).not.toBe('');
        expect(warnings).toEqual([]);
    });
});
