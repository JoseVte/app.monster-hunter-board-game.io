// The props each page under `Pages/Wiki` and `Pages/Auth` is handed in a
// test, shared by `smoke.test.ts`, which mounts every one of them in a DOM, and
// `ssr.test.ts`, which renders every one of them on a Node server the way the
// production SSR bundle does. They used to live inside the smoke test; two
// suites reading one bag is what keeps the two from testing different pages
// with different data and calling it the same coverage.
import type {Component} from 'vue';
import * as fixtures from './fixtures';

// Every page and partial under Pages/Wiki. The 29 shared Components/ they use
// are mounted transitively as children, which is better coverage than mounting
// them standalone: it exercises the props the pages really pass them.
export const wikiComponents = import.meta.glob('/resources/js/Pages/Wiki/**/*.vue');

// Every page under Pages/Auth. Nineteen of the Wiki's 29 shared components are
// also used outside it: `Form/TextInput.vue` and `Form/InputLabel.vue` by 26
// files each, `SecondaryButton.vue` by 16, `Breadcrumb.vue` by 10. The Wiki
// glob above cannot see any of that; Auth is the cheapest useful widening,
// nine pages, the heaviest consumers of the form components, self contained
// enough to mount without a real session or a running SSR server. Kept as its
// own `import.meta.glob` call rather than merged into one brace pattern with
// the Wiki glob above, so each keeps its own count guard below: a brace
// pattern that silently matched only one side would be the same
// green-covering-nothing failure those guards exist to prevent.
export const authComponents = import.meta.glob('/resources/js/Pages/Auth/**/*.vue');

export const components = {...wikiComponents, ...authComponents};

// `Wiki/Weapon/Show.vue` (and, transitively, `Hunter/Partials/ListWeapons.vue`)
// does not take a flat list of weapons: the controller builds one entry per
// root weapon, each carrying every buildable path out of it, and the tree
// component reduces over that shape (`entry.paths[].weapons[].rarity`, and so
// on). Passing the plain `fixtures.weapon` array here, the way every other
// page's `weapons` key wants it, throws inside `ListWeapons.vue` the moment it
// tries to read `entry.paths`. See `App\Support\helpers.php`'s
// `create_weapon_tree()` for the real shape this stands in for.
export const weaponTree = [
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
export const part = fixtures.monster.difficulties![0].parts![0];

// Every option list a `*Filters.vue` partial reads through `props.options`.
// Each is read with a bare `.map(...)`, so a key this leaves out throws before
// any of the four pages that pass filters even reach the DOM; the real shape
// comes from each Wiki controller's own `options()` method.
export const options = {
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
export const hunterForCrafting = {
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
//
// The Auth pages' own props are merged into this same bag rather than kept
// separate: none of the keys below collide with a Wiki key, a page ignores
// whatever it did not declare, and a single bag is one less thing to keep in
// sync as pages move between the two globs. Read from every one of the 9
// files' `defineProps`, the same way the Wiki keys were:
// - `AcceptCampaignInvitation.vue`: invitation, signature, email, campaign
// - `AcceptInvitation.vue`: token, email, inviter
// - `ForgotPassword.vue`/`VerifyEmail.vue`: status
// - `Login.vue`: canResetPassword, status
// - `ResetPassword.vue`: email, token
// `ConfirmPassword.vue`, `Register.vue` and `TwoFactorChallenge.vue` declare
// no props at all.
export const pageProps = {
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
    invitation: 1,
    signature: '/invitations/accept-campaign/1?signature=test',
    email: 'test@example.com',
    campaign: 'Iceborne Crew',
    token: 'test-token',
    inviter: 'Test Hunter',
    status: 'verification-link-sent',
    canResetPassword: true,
};

// Every Auth page's template is `<Head /><AuthenticationCard>...`, two root
// nodes rather than one. Passing the whole `props` bag above to a component
// like that makes Vue warn ("Extraneous non-props attributes ... could not be
// automatically inherited because component renders fragment or text or
// teleport root nodes"): a single-root Wiki page silently binds an
// undeclared key to its root element, but a fragment root has no single
// place to put it, so Vue says so instead of guessing. That guess would be
// wrong to suppress: in the real app a controller only ever sends the props a
// page's own `defineProps` names, so an Auth page never actually receives the
// other 20-odd Wiki keys sitting in this shared bag. Filtering each mount
// down to what the component declares (a compiled `<script setup>` component
// exposes that as its own `.props`, an object keyed by prop name, or is left
// `undefined` for a page that declares none) matches production rather than
// merely working around a test artifact.
//
// `Component` (the public, structural type `@vue/test-utils` and this file's
// own glob results traffic in) does not expose that field, so naming it here
// as its own type is a deliberate reach for a compiler-generated field, not a
// cast someone got away with.
type CompiledSfc = {props?: Record<string, unknown>};

export function propsFor(component: Component): Record<string, unknown> {
    const declared = (component as unknown as CompiledSfc).props;

    if (! declared) {
        return {};
    }

    return Object.fromEntries(
        Object.keys(declared)
            .filter((name) => name in pageProps)
            .map((name) => [name, pageProps[name as keyof typeof pageProps]]),
    );
}
