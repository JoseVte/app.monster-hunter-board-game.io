import {flushPromises} from '@vue/test-utils';
import {afterEach, describe, expect, it} from 'vitest';
import {mountComponent} from './setup';
import WysiwygInput from '@/Components/Form/WysiwygInput.vue';

// `setup.ts` stubs this component for every other suite, because the real one
// used to fetch stylesheets and scripts from `unpkg.com` the moment it mounted.
// Mounted directly, as the root rather than as a child, the stub does not apply
// and the real `md-editor-v3` runs, which is what this has to look at.
//
// What it guards is a property of the whole app, not of the editor: the browser
// talks to no third party except reCAPTCHA on the forms that verify a token
// (see "Cookies and tracking" in CLAUDE.md). The editor was the one thing on the
// campaign forms that broke it, by handing every visitor's address to a CDN to
// fetch features the server-side renderer never draws anyway.
function remoteAssets(): string[] {
    return Array.from(document.querySelectorAll<HTMLLinkElement | HTMLScriptElement>('link[href], script[src]'))
        .map((element) => ('href' in element ? element.href : element.src))
        .filter((url) => /^https?:\/\//.test(url) && ! url.startsWith(window.location.origin));
}

afterEach(() => {
    document.head.querySelectorAll('link, script').forEach((element) => element.remove());
});

describe('WysiwygInput', () => {
    it('mounts the real editor', async () => {
        const wrapper = mountComponent(WysiwygInput, {modelValue: '# A campaign'});

        await flushPromises();

        // Without this the next assertion could pass by the editor never
        // having rendered at all.
        expect(wrapper.find('.md-editor').exists()).toBe(true);
    });

    it('fetches nothing from a third party', async () => {
        mountComponent(WysiwygInput, {modelValue: '# A campaign\n\n```php\necho 1;\n```\n\n$$x^2$$'});

        await flushPromises();

        expect(remoteAssets()).toEqual([]);
    });
});
