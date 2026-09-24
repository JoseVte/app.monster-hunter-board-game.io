// Hand written, like `vendor-models.d.ts` but unlike the two generated files
// next to it, because share() returns a PHP array literal rather than a class
// and there is nothing to reflect over. It lives here rather than beside the
// models for the same reason: it describes a method, not a table.
//
// Keys and shapes read from `App\Http\Middleware\HandleInertiaRequests::share()`
// and `Laravel\Jetstream\Http\Middleware\ShareInertiaData::handle()`, not
// copied from a sketch. `share()` writes `'user.roles'`, `'user.campaigns'`
// and its two siblings as top-level array keys with a full stop in the name,
// but nothing downstream ever receives that flat shape: `unpackDotProps()`
// (`vendor/inertiajs/inertia-laravel/src/PropsResolver.php`, called from
// `resolve()`) runs on every request before a page sees its props, turns any
// top-level dotted key into a nested path with `Arr::set()`, and deletes the
// flat original. What actually reaches the browser, and what
// `Profile/Level.vue` already reads (`usePage().props.user.achievements`), is
// one nested `user` object, not four flat, dotted keys; this file used to
// declare the latter, a shape checked against a comment rather than a real
// payload.
import type {ComposerTranslation} from 'vue-i18n';
import type {Page, PageProps, Router, SharedPageProps} from '@inertiajs/core';

// Named `Inertia`, not `App.Inertia`. This file has a top-level `import` and
// a closing `export {}`, which makes it a module, and a `declare namespace
// App.Inertia {}` inside a module creates a namespace local to that module,
// not a merge into the global `App` namespace `generated.d.ts` and
// `vendor-models.d.ts` declare (both script files, with no top-level
// `import`/`export` of their own, which is what makes their `App` genuinely
// global). A local `App` shadows the global one for the rest of this file:
// every `App.Models.*` reference below used to resolve against this file's
// own, Models-less `App`, not the real one, and silently typed as `any`
// rather than failing loudly, because `skipLibCheck: true` (the project's
// normal setting; `npm run typecheck` runs under it) hides exactly this
// shape of error. Caught only by running `npx tsc --noEmit --skipLibCheck
// false`, which stopped hiding it and reported `TS2694: Namespace 'App' has
// no exported member 'Models'` three times, once per property below that
// names a model. Dropping the `App.` prefix here removes the shadow: `App`
// inside `SharedProps` now resolves to the real global namespace, because
// nothing in this file declares a local one to get in its way.
declare namespace Inertia {
    export type SharedProps = {
        // `errors` comes from Inertia itself (`parent::share()`), not from this
        // method's own array literal, but it is merged into the same payload.
        errors: Record<string, string>;
        // `errorBags`, `auth` and `jetstream` come from a second middleware,
        // Jetstream's own `ShareInertiaData`, layered on top of
        // `HandleInertiaRequests::share()` rather than written inside it,
        // which is why they read nothing like the header comment above.
        errorBags: Record<string, Record<string, string[]>>;
        auth: {
            // `$request->user()`; the closure `return;`s with no user, which
            // is `null` in the array Inertia serialises, not an absent key,
            // so this stays required rather than optional. Otherwise
            // `$user->toArray()` (`password`, `remember_token` and the two
            // two-factor columns are `$hidden`), merged with `all_teams` only
            // when `Jetstream::userHasTeamFeatures($user)` is true for that
            // user (this app's own config turns on team features globally,
            // so in practice that is every authenticated user), and
            // `two_factor_enabled`, always present once a user exists.
            // `current_team` is the same conditional relation: present, and
            // possibly `null`, only once loaded, which happens under that
            // same team-features check.
            user: (App.Models.User & {
                current_team?: App.Models.Team | null;
                all_teams?: Array<App.Models.Team>;
                two_factor_enabled: boolean;
            }) | null;
        };
        jetstream: {
            canCreateTeams: boolean;
            canManageTwoFactorAuthentication: boolean;
            canUpdatePassword: boolean;
            canUpdateProfileInformation: boolean;
            hasEmailVerification: boolean;
            // Read by `Banner.vue` as `flash?.bannerStyle`/`flash?.banner`,
            // both already optional there, so kept optional here rather than
            // widened to `string`, which would let a banner-less flash
            // (the far more common case) fail to compile against its reader.
            flash: {bannerStyle?: string; banner?: string};
            hasAccountDeletionFeatures: boolean;
            hasApiFeatures: boolean;
            hasTeamFeatures: boolean;
            hasTermsAndPrivacyPolicyFeature: boolean;
            managesProfilePhotos: boolean;
        };
        // `(new Ziggy)->toArray()` merged with a `location` and `query` this
        // method adds itself; the rest of Ziggy's own shape (`url`, `port`,
        // `defaults`, `routes`) is not worth re-declaring here, since nothing
        // in the app reads `$page.props.ziggy` for anything but the plugin's
        // own bootstrapping.
        ziggy: {location: string; query: Record<string, string>} & Record<string, unknown>;
        recaptcha_site_key: string | null;
        // `Route::has('register')`.
        canRegister: boolean;
        socialLogin: {
            // `collect([...])->filter(...)->values()`: only a provider whose
            // client_id is configured survives, but the source list is exactly
            // these three, so this stays a literal union rather than `string[]`.
            providers: Array<'google' | 'github' | 'discord'>;
            // `$user->providers->pluck('provider')`.
            linked: string[];
            hasPassword: boolean;
        };
        // `$request->route('campaign')`, a route-model-bound Eloquent instance
        // or null; never narrowed to a subset of Campaign's fields here.
        current_campaign: App.Models.Campaign | null;
        current_campaign_id: number | null;
        has_campaign_hunter: boolean;
        locale: string;
        // One nested object, the way `unpackDotProps()` actually delivers it
        // (see this file's header comment), not the four flat, dotted keys
        // `share()`'s own source reads as literal array keys.
        user: {
            campaigns: Array<App.Models.Campaign>;
            roles: string[];
            permissions: string[];
            achievements: Array<App.Models.Achievement>;
        };
        // `asKeyLabelObjectSelectable()`: `key` is the enum case's name, `label`
        // its translated label. Neither is the enum type itself.
        dayType: Array<{key: string; label: string}>;
        monsterDifficulty: Array<{key: string; label: string}>;
        jetstreamAcceptText: string;
        level: {
            current: number | null;
            next: number | null;
            next_percentage: number | null;
            points: number | null;
        };
    };
}

// `@inertiajs/core`'s own `PageProps` is `{ [key: string]: unknown; }`, an
// index signature, and merging `SharedProps` into it here adds the keys below
// as correctly typed on top without removing that signature (the documented
// alternative, `declare module '@inertiajs/core' { interface InertiaConfig {
// sharedPageProps: {...} } }`, has the identical gap: it is still a plain
// object type composed the same way). So a misspelt *route name* is a compile
// error (see `ziggy-global.d.ts`), but a misspelt *prop key* is not:
// `page.props.canRegisterXYZ` still compiles, typed `unknown` off the index
// signature, and only fails later if it is used somewhere that rejects
// `unknown`. Worth knowing before generalising from the route-name probe in
// this file's neighbour.
declare module '@inertiajs/core' {
    interface PageProps extends Inertia.SharedProps {}
}

// This augments `'@vue/runtime-core'`, not the more obvious-looking `'vue'`.
// `vue`'s own package re-exports `@vue/runtime-dom`, which itself does
// `export * from '@vue/runtime-core'` and augments *that* module (not `vue`,
// not `@vue/runtime-dom`) for its own DOM-specific additions. Confirmed by
// reading `node_modules/@vue/runtime-dom/dist/runtime-dom.d.ts`, which has its
// own `declare module '@vue/runtime-core' {...}` block. That is the module an
// SFC's component-instance type is actually built from with this vue-tsc and
// Vue version, so it is the one whose `ComponentCustomProperties` a template
// expression's type-checking consults.
//
// An augmentation of `'vue'` itself is not wrong, exactly, but it is inert:
// `tsc` accepts it, and script code that reads `this.route(...)` even sees
// it, but a template's `$t(...)`/`route(...)` still comes back "property does
// not exist". `'vue'` is exactly what this interface augmented before this
// fix moved it here, with `replaceIcons`, `getRarityColor`, `route` and `$t`
// already declared and all four already broken inside a template, never
// inside script (`$page` and `$inertia`, declared below, joined the block
// afterwards, already targeting `@vue/runtime-core`, so they never went
// through a broken `'vue'` phase of their own). Proof, not
// just argument, since this is easy to "fix" back by a reader who has not hit
// the symptom: drop a throwaway `.vue` anywhere in `resources/js` with
//
//   <script setup lang="ts"></script>
//   <template><span>{{ $t('x') }}{{ route('dashboard') }}
//     {{ replaceIcons('y') }}{{ getRarityColor(1) }}</span></template>
//
// and run `npm run typecheck`. Against `declare module 'vue'` all four report
// TS2339. Against `declare module '@vue/runtime-core'` (this file, as it
// stands) none do. Delete the probe file again afterwards; it proves nothing
// by existing, only by being run.
declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        // Matches `resources/js/icons.ts`'s and `resources/js/rarity.ts`'s own
        // declared signatures, not the loosely sketched ones in the plan: the
        // real `replaceIcons` passes `null`/`undefined` straight through.
        replaceIcons: (text: string | null | undefined) => string | null | undefined;
        getRarityColor: (rarity?: number) => string;
        // `route` itself is declared in `ziggy-global.d.ts`, next to the
        // generated route list it is typed against; it is added to this
        // interface here rather than there because that file has to stay a
        // script (no top-level `import`/`export`) for its own `declare module
        // 'ziggy-js';` line to create the module rather than augment it, and
        // `declare module '@vue/runtime-core' {...}` from a script file would
        // replace that module outright instead of merging with it. This block
        // is already a module-file augmentation of the real module, so it
        // merges safely.
        route: typeof route;
        // `app.ts` calls `createI18n({legacy: false, ...})` with no explicit
        // `globalInjection`, which defaults to `true`: the plugin installs the
        // *global* composer's `t` as `app.config.globalProperties.$t`, the
        // same function `useI18n().t` returns elsewhere. vue-i18n's own
        // `.d.ts` does declare a `$t` on `ComponentCustomProperties`, but it
        // augments `'vue'`, which per the note above is not the module this
        // toolchain's template checking consults, so it is repeated here
        // against `ComposerTranslation`, the exported type of that same `t`,
        // rather than a hand-sketched signature. The rule is not specific to
        // vue-i18n: `@inertiajs/vue3` makes the identical choice for `$page`
        // and `$inertia` below (`node_modules/@inertiajs/vue3/types/types.
        // d.ts` augments `'vue'` too), so both are repeated here as well,
        // against Inertia's own exported types rather than sketched by hand.
        $t: ComposerTranslation;
        $page: Page<PageProps & SharedPageProps>;
        $inertia: Router;
    }
}

export {};
