import type {Component} from 'vue';
import {flushPromises} from '@vue/test-utils';
import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import {mountComponent} from './setup';
import {authComponents, components, propsFor, wikiComponents} from './pageProps';

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
        expect(Object.keys(wikiComponents).length).toBeGreaterThanOrEqual(16);
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
        const paths = Object.keys(wikiComponents);

        for (const path of [
            '/resources/js/Pages/Wiki/Monster/Show.vue',
            '/resources/js/Pages/Wiki/Weapon/Detail.vue',
            '/resources/js/Pages/Wiki/Armor/Detail.vue',
            '/resources/js/Pages/Wiki/Item/Show.vue',
        ]) {
            expect(paths).toContain(path);
        }
    });
});

describe('every Auth component', () => {
    // Same reasoning as the Wiki glob's own guard above: a glob matching
    // nothing would turn every it.each below into a silent pass, and the two
    // globs are kept separate specifically so neither can hide a collapse of
    // the other behind a healthy combined count.
    it('is found by the glob', () => {
        expect(Object.keys(authComponents).length).toBeGreaterThanOrEqual(9);
    });

    // Same reasoning as the Wiki sample above: `toBe(9)` would fail on every
    // legitimate new Auth page, so this names a sample instead, chosen as the
    // heaviest consumers of the shared form components this plan converts
    // (`Form/TextInput.vue` and `Form/InputLabel.vue`, both used by 26 files
    // across the app) plus the platform invitation flow documented in
    // CLAUDE.md's "Invitations" section.
    it('includes the heaviest form consumers by name, not just by count', () => {
        const paths = Object.keys(authComponents);

        for (const path of [
            '/resources/js/Pages/Auth/Login.vue',
            '/resources/js/Pages/Auth/Register.vue',
            '/resources/js/Pages/Auth/ForgotPassword.vue',
            '/resources/js/Pages/Auth/AcceptInvitation.vue',
        ]) {
            expect(paths).toContain(path);
        }
    });
});

describe('every Wiki and Auth component', () => {
    it.each(Object.keys(components))('%s mounts and renders', async (path) => {
        const module = (await components[path]()) as {default: Component};

        const wrapper = mountComponent(module.default, propsFor(module.default));

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

// "Mounts and does not warn" cannot see a conversion that renders something
// different. These four are the densest pages in the batch: if a computed's
// result or a v-if's condition changes meaning under TypeScript, the diff
// shows up here and nowhere else.
describe.each([
    '/resources/js/Pages/Wiki/Monster/Show.vue',
    '/resources/js/Pages/Wiki/Weapon/Detail.vue',
    '/resources/js/Pages/Wiki/Armor/Detail.vue',
    '/resources/js/Pages/Auth/Login.vue',
])('%s', (path) => {
    it('renders the same markup it rendered before the conversion', async () => {
        const module = (await components[path]()) as {default: Component};

        const wrapper = mountComponent(module.default, propsFor(module.default));

        await flushPromises();

        expect(wrapper.html()).toMatchSnapshot();
    });
});
