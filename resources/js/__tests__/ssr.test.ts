// @vitest-environment node
//
// Every Wiki and Auth page, rendered the way the production SSR bundle renders
// it: through `renderPage()` from `ssrRender.ts`, the same function `ssr.ts`
// hands to `createServer()`, in a Node environment with no `window`, no
// `document` and no `sessionStorage`. `smoke.test.ts` mounts the same pages in
// happy-dom, which has all three, so it could never see the failures this
// exists for.
//
// Two of them were in production, unseen. `ssr.ts` installed neither vue-i18n
// nor the icon mixin, so every server render of a page calling `$t()` died and
// fell back to the client. And `useRecaptcha()` called `recaptcha-v3`'s
// `load()` during `setup`, which on the server is a rejected promise nobody
// awaits, and Node exits on those: the first `/login` killed the SSR process.
import {afterEach, beforeAll, beforeEach, describe, expect, it, vi} from 'vitest';
import type {Component} from 'vue';
import type {Page} from '@inertiajs/core';
import {sharedPageProps} from './setup';
import {components, propsFor} from './pageProps';
import {createProps, editProps} from './campaignPageProps';
import {renderPage} from '@/ssrRender';

// `setup.ts` replaces `@/recaptcha` for every other suite. Here the real
// composable has to run, since how it behaves on a server is the point.
vi.unmock('@/recaptcha');

// What `recaptcha-v3`'s `load()` actually does in Node, rather than its real
// code, so the test can say "it was never called" outright.
//
// The calls go into a plain array that nothing resets, not into a `vi.fn()`'s
// own history. `recaptcha.ts` keeps its promise at module scope, so only the
// first page to load the script ever reaches `load()`; a history wiped between
// tests (which `restoreAllMocks` does) left a check in a later test looking at
// an empty record and passing with the bug put straight back in. That is how
// the first version of this suite went green with `load()` moved back into
// `setup`. Every page's own case asserts the array is still empty, so the page
// that breaks it is the one that fails, whatever order they run in.
const recaptcha = vi.hoisted(() => ({calls: [] as unknown[][]}));

vi.mock('recaptcha-v3', () => ({
    load: (...args: unknown[]) => {
        recaptcha.calls.push(args);

        return Promise.reject(new Error('This is a library for the browser!'));
    },
}));

// Ziggy needs the real route list to resolve a name, and every other suite
// fakes `route()` for the same reason (see `setup.ts`). The fake is installed
// the two ways the real `ZiggyVue.install()` installs it (read from
// `vendor/tightenco/ziggy/dist/vue.m.js`): a mixin method, which is what a
// template's `route(...)` reaches, and `app.provide('route', ...)`, which is
// what a component injects when it needs a URL while rendering.
vi.mock('../../../vendor/tightenco/ziggy/dist/vue.m', () => ({
    ZiggyVue: {
        install(app: {mixin: (mixin: object) => void; provide: (key: string, value: unknown) => void}) {
            const fake = (name?: string) => (name === undefined ? {current: () => false} : `/${name}`);

            app.mixin({methods: {route: fake}});
            app.provide('route', fake);
        },
    },
}));

// `setup.ts` also puts a `route` on `globalThis` for `<script setup>` code
// that calls it bare. Blade's `@routes` is what provides that in a browser, and
// a Node process has nothing of the kind, so it is taken away here: a page
// that calls a bare `route()` while rendering is a page that cannot render on
// the server, and this suite should say so.
beforeAll(() => {
    Reflect.deleteProperty(globalThis, 'route');
});

function pageFor(path: string, props: Record<string, unknown>, locale = 'en'): Page {
    return {
        component: path.replace('/resources/js/Pages/', '').replace(/\.vue$/, ''),
        props: {
            ...sharedPageProps,
            locale,
            // `renderPage()` builds a `URL` from this, which an empty string
            // (the DOM suites' value, where nothing parses it) is not.
            ziggy: {location: 'http://localhost/', query: {}},
            ...props,
        },
        url: '/',
        version: null,
        rescuedProps: [],
        flash: {},
        rememberedState: {},
    };
}

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

describe('server side rendering', () => {
    it('is handed every page the DOM suite mounts', () => {
        // The same guard `smoke.test.ts` carries, for the same reason: a glob
        // that matched nothing would make every case below a silent pass.
        expect(Object.keys(components).length).toBeGreaterThanOrEqual(25);
    });

    it.each(Object.keys(components))('%s renders on the server', async (path) => {
        const module = (await components[path]()) as {default: Component};

        const {body} = await renderPage(pageFor(path, propsFor(module.default)));

        expect(body).toContain('data-server-rendered="true"');
        expect(warnings).toEqual([]);
        expect(recaptcha.calls).toEqual([]);
    });

    // The two campaign forms carry the markdown editor, which read `document`
    // while setting up and so could not render on a server at all.
    it.each([
        ['/resources/js/Pages/Campaign/Create.vue', createProps],
        ['/resources/js/Pages/Campaign/Edit.vue', editProps],
    ])('%s renders on the server', async (path, props) => {
        const {body} = await renderPage(pageFor(path, props));

        expect(body).toContain('data-server-rendered="true"');
        expect(warnings).toEqual([]);
    });

    it('never loads reCAPTCHA while rendering a page that uses it', async () => {
        await renderPage(pageFor('/resources/js/Pages/Auth/Login.vue', {canResetPassword: true}));

        expect(recaptcha.calls).toEqual([]);
    });

    it('translates on the server, in the locale of each request', async () => {
        // Rendered together on purpose. The SSR process serves every request
        // from one module, so an i18n instance created once at module scope
        // would hand whichever locale rendered last to the next visitor.
        // `installAppPlugins()` builds one per call; this is what holds it to
        // that.
        const [english, spanish] = await Promise.all([
            renderPage(pageFor('/resources/js/Pages/Auth/Login.vue', {canResetPassword: true}, 'en')),
            renderPage(pageFor('/resources/js/Pages/Auth/Login.vue', {canResetPassword: true}, 'es')),
        ]);

        expect(english.body).toContain('Forgot your password?');
        expect(english.body).not.toContain('¿Olvidó su contraseña?');
        expect(spanish.body).toContain('¿Olvidó su contraseña?');
        expect(spanish.body).not.toContain('Forgot your password?');
    });

    it('titles a page with the app name it is sent, not one read from the environment', async () => {
        const {head} = await renderPage(pageFor('/resources/js/Pages/Auth/Login.vue', {canResetPassword: true}));

        expect(head.join('')).toContain(`Log in - ${sharedPageProps.appName}`);
    });
});
