import {config, mount} from '@vue/test-utils';
import {defineComponent, nextTick} from 'vue';
import type {Component} from 'vue';
import {createI18n} from 'vue-i18n';
import {App as InertiaApp, usePage} from '@inertiajs/vue3';
import {replaceIcons} from '@/icons';
import {getRarityColor} from '@/rarity';

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
type RouteFn = (name?: string, params?: unknown) => string | {current: () => boolean};

const route: RouteFn = (name) => {
    if (name === undefined) {
        return {current: () => false};
    }

    return `/${name}`;
};

declare global {
    var route: RouteFn;
}

globalThis.route = route;

config.global.plugins = [i18n];

config.global.mixins = [{methods: {replaceIcons, getRarityColor, route}}];

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
                // for the same reason.
                auth: {
                    user: {
                        name: 'Test Hunter',
                        email: 'test@example.com',
                        profile_photo_url: '/images/avatar.png',
                        current_team: null,
                        campaigns: [],
                    },
                },
                // `level.current`/`.next_percentage` are read unconditionally
                // by AppLayout.vue (the profile dropdown's level bar is not
                // behind the `hasApiFeatures` gate, only the API tokens link
                // next to it is).
                jetstream: {
                    hasTeamFeatures: false,
                    managesProfilePhotos: false,
                    hasApiFeatures: false,
                    canCreateTeams: false,
                    flash: {},
                },
                level: {current: 1, next: 100, next_percentage: 0, points: 0},
                locale: 'en',
                current_campaign: null,
                current_campaign_id: null,
                has_campaign_hunter: false,
                // Inertia's own `PageProps` requires this even though nothing
                // under test reads it.
                errors: {},
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
