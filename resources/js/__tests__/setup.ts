import {config, mount} from '@vue/test-utils';
import {defineComponent, nextTick} from 'vue';
import type {Component} from 'vue';
import {createI18n} from 'vue-i18n';
import {App as InertiaApp, usePage} from '@inertiajs/vue3';
import {vi} from 'vitest';
import {replaceIcons} from '@/icons';
import {getRarityColor} from '@/rarity';

// Five Auth pages (Login, Register, ForgotPassword, AcceptInvitation,
// AcceptCampaignInvitation) call `useRecaptcha(...)` unconditionally inside
// `<script setup>`, not just on submit. The real implementation
// (`resources/js/recaptcha.ts`) calls `recaptcha-v3`'s `load()`, which appends
// a real `<script src="https://www.google.com/recaptcha/api.js...">` to
// `document.head` and resolves only once that element fires a `load` event.
// happy-dom never fetches or executes an external script, so that event never
// fires and the promise it returns hangs forever, once per process, since
// `recaptcha.ts` caches the load in a module-level variable, so every page
// after the first shares the same never-resolving promise. Mounting is
// synchronous, so no test actually waits on it, but the dangling script tag
// and the pending promise are a real leak the harness should not paper over
// by accident, so the module is replaced outright rather than left to hang.
//
// `vi.mock(import('@/recaptcha'), ...)` rather than `vi.mock('@/recaptcha',
// ...)`: the string-path overload types the factory's return as `unknown`, so
// nothing would check this fake against the real module's exports. Passing
// the dynamic import ties the factory's return type to `typeof
// import('@/recaptcha')`, so renaming `useRecaptcha` or changing `execute`'s
// signature in the real module fails `npm run typecheck` here rather than
// staying silently green.
vi.mock(import('@/recaptcha'), () => ({
    useRecaptcha: () => ({
        execute: async () => 'test-recaptcha-token',
    }),
}));

// `missingWarn`/`fallbackWarn` default to true, and every `$t()` call in every
// component would warn on it: the catalog here is empty on purpose, since no
// component's rendering is supposed to depend on the actual translated text,
// only on `$t` existing and returning something printable. Left at their
// defaults, that warning would drown out the one this suite exists to catch.
const i18n = createI18n({
    legacy: false,
    locale: 'en',
    fallbackLocale: 'en',
    messages: {en: {}},
    missingWarn: false,
    fallbackWarn: false,
});

// Ziggy's real Vue plugin (`app.js`) does not attach `route` to `window`; the
// global function comes from the `@routes` Blade directive instead, and the
// plugin only adds `route` as a mixin method, which is what makes `route(...)`
// resolve inside a component's `<template>`. A component's `<script setup>`
// block, on the other hand, calls the bare, truly-global one (see
// `WikiFilters.vue`'s `router.get(route(...))`). Both call sites need to work,
// so `route` is set up twice: once as a real global for script code, once as a
// mixin method for templates. A version that only did the first looked correct
// until the first component whose template called `route(...)` directly threw
// "route is not a function", because `_ctx.route` and `globalThis.route` are
// not the same lookup.
//
// The URL it returns is never asserted; what matters is that a template or a
// script calling it does not throw. `route()` with no arguments has to return
// something with a `.current()` method too, since `AppLayout.vue` calls
// `route().current('dashboard')` to highlight the active nav link.
//
// `route` is a real ambient global now (`resources/js/types/ziggy-global.d.ts`,
// declared against the generated route list), so it is not redeclared here;
// declaring it again would be a duplicate identifier. Giving this mock the
// same two overloads as that real `route`, `string` standing in for `keyof
// RouteList` (a valid contravariant widening: every real route name is a
// `string`, so a function willing to accept any `string` can stand in for one
// that only promises to accept known route names), is what lets
// `globalThis.route = mockRoute` below assign with no cast at all, so a
// future change to either signature is still checked here instead of being
// silently absorbed by an `as unknown as`.
function mockRoute(): {current(name?: string): boolean};
function mockRoute(name: string, params?: unknown): string;
function mockRoute(name?: string): string | {current(name?: string): boolean} {
    if (name === undefined) {
        return {current: () => false};
    }

    return `/${name}`;
}

globalThis.route = mockRoute;

config.global.plugins = [i18n];

config.global.mixins = [{methods: {replaceIcons, getRarityColor, route: mockRoute}}];

config.global.stubs = {
    // Inertia's own components need a running app and are not what is under test.
    Link: {template: '<a><slot /></a>'},
    Head: {template: '<div><slot /></div>'},
};

// A handful of components read `usePage()` or the injected `$page` global
// property directly (`AppLayout.vue`, `Banner.vue`, `LocaleDropdown.vue`,
// `HunterBanner.vue`, `DropdownCampaign.vue`, `DropdownTeam.vue`), all reached
// transitively through every Wiki page's `<AppLayout>` wrapper. Neither works
// out of the box: `usePage()`'s state lives in a module-level ref inside
// `@inertiajs/vue3` that only gets set by mounting the library's own `<App>`
// root component, and `$page` is a global property that only the library's
// own Vue plugin installs.
//
// Rather than re-implementing what those two do, this mounts the real `<App>`
// once, with a fake `initialPage`, so `usePage()` starts returning real data
// the normal way. `resolveComponent` is asynchronous even when it does not
// look it (Inertia treats it as a promise internally), so the two flushes
// below wait for that resolution and the render it triggers to settle before
// any test runs; skipping them lets a stray "component missing a render
// function" warning surface during a later, unrelated test instead of here.
async function flush() {
    await nextTick();
    await new Promise((resolve) => setTimeout(resolve, 0));
    await nextTick();
}

mount(InertiaApp, {
    props: {
        initialPage: {
            component: 'Smoke',
            props: {
                // AppLayout.vue reads `auth.user.current_team` and
                // `auth.user.campaigns` through `usePage()` directly, and
                // `auth.user.name`/`.email` through the `$page` global
                // property in its template. A null `current_team` keeps the
                // team-switching branches, which need a much larger shape
                // (`all_teams`, etc.), out of the picture entirely: they are
                // gated behind `jetstream.hasTeamFeatures`, set to false below
                // for the same reason. `auth.user` is typed against the real
                // `App.Models.User` plus Jetstream's own additions now
                // (`resources/js/types/inertia.d.ts`), so the base columns
                // nothing under test reads (`id`, `email_verified_at`, and so
                // on) still need a placeholder value each; `two_factor_enabled`
                // is Jetstream's own addition, not the model's, and is
                // required the same way.
                auth: {
                    user: {
                        id: 1,
                        name: 'Test Hunter',
                        email: 'test@example.com',
                        email_verified_at: null,
                        two_factor_confirmed_at: null,
                        current_team_id: null,
                        current_connected_account_id: null,
                        profile_photo_path: null,
                        created_at: null,
                        updated_at: null,
                        profile_photo_url: '/images/avatar.png',
                        current_team: null,
                        campaigns: [],
                        two_factor_enabled: false,
                    },
                },
                // `level.current`/`.next_percentage` are read unconditionally
                // by AppLayout.vue (the profile dropdown's level bar is not
                // behind the `hasApiFeatures` gate, only the API tokens link
                // next to it is). `jetstream` is typed against every field
                // `ShareInertiaData::handle()` actually sends now, not just
                // the five below this suite reads, so the rest are filler too.
                jetstream: {
                    hasTeamFeatures: false,
                    managesProfilePhotos: false,
                    hasApiFeatures: false,
                    canCreateTeams: false,
                    flash: {},
                    canManageTwoFactorAuthentication: false,
                    canUpdatePassword: false,
                    canUpdateProfileInformation: false,
                    hasEmailVerification: false,
                    hasAccountDeletionFeatures: false,
                    hasTermsAndPrivacyPolicyFeature: false,
                },
                level: {current: 1, next: 100, next_percentage: 0, points: 0},
                locale: 'en',
                current_campaign: null,
                current_campaign_id: null,
                has_campaign_hunter: false,
                // `Login.vue` reads `canRegister` through `$page.props` to
                // decide whether `AuthenticationCard` offers a login or a
                // register link. `false` (the app's own default, see
                // `config/fortify.php`'s `AUTH_CAN_REGISTER` gate) exercises
                // the branch every other page in this bag never touches.
                canRegister: false,
                // Read by every Auth page that calls `useRecaptcha` (see the
                // mock above); the value itself is never inspected by the
                // mock, but it stands in for the real
                // `config('services.google-recaptcha.site-key')` share.
                recaptcha_site_key: 'test-site-key',
                // Inertia's own `PageProps` requires this even though nothing
                // under test reads it.
                errors: {},
                // The seven keys below are the rest of `Inertia.SharedProps`
                // (`resources/js/types/inertia.d.ts`): `share()` (plus, for
                // `errorBags`, Jetstream's `ShareInertiaData`) sends every one
                // of them unconditionally, so the type requires them too, and
                // none of the Wiki/Auth pages or shared components this suite
                // mounts reads any of them except `SocialLogin.vue`'s
                // `socialLogin.providers`, which already falls back with `??`.
                // Left at the emptiest value their type allows, the same way
                // `errors` above is. `user` is one nested object, not the
                // four flat, dotted keys this file used to list here:
                // `PropsResolver::unpackDotProps()` nests every dotted
                // top-level key from `share()` before a page ever sees it, so
                // `'user.achievements'` was never a real key at runtime; see
                // `inertia.d.ts`'s own header comment for the source dive.
                errorBags: {},
                ziggy: {location: '', query: {}},
                socialLogin: {providers: [], linked: [], hasPassword: false},
                user: {campaigns: [], roles: [], permissions: [], achievements: []},
                dayType: [],
                monsterDifficulty: [],
                jetstreamAcceptText: '',
            },
            url: '/',
            version: null,
            // `Page`'s own bookkeeping fields, required by the type even
            // though nothing under test reads them either.
            rescuedProps: [],
            flash: {},
            rememberedState: {},
        },
        resolveComponent: () => defineComponent({render: () => null}),
    },
});

await flush();

config.global.mocks = {$page: usePage()};

// A thin wrapper over `@vue/test-utils`'s own `mount`, so a later suite can
// mount a page without re-establishing the i18n plugin, the `route`/icon
// mixins, the Link/Head stubs and the `$page` mock set up above: all of that
// already applies to a bare `mount()` call too, since it lives on the shared
// `config.global` object, but importing this instead names the dependency on
// this setup file explicitly rather than leaning on it implicitly.
export function mountComponent(component: Component, props?: Record<string, unknown>) {
    return mount(component, {props});
}
