// What every Vue app this project builds has installed, in the browser and on
// the SSR server alike.
//
// The two entry points used to assemble this list each on their own, and they
// drifted: `app.ts` installed vue-i18n and the `replaceIcons`/`getRarityColor`
// mixin, `ssr.ts` installed neither, so every server render of a component
// that called `$t()` died with "Need to install with 'app.use' function". The
// SSR config has `throw_on_error: false`, so production built and shipped the
// bundle, failed every render with it, and fell back to client rendering with
// nothing in the logs. One function both entries call is what stops that from
// happening again.
//
// What stays out of here is what only one side can have. `vue3-storage` wraps
// `sessionStorage`, which a Node process does not have, and Ziggy is
// configured from a different source on each side (Blade's `@routes` global
// in the browser, the page's own `ziggy` prop on the server).
import {createI18n} from 'vue-i18n';
import type {App} from 'vue';
import {replaceIcons} from './icons';
import {getRarityColor} from './rarity';
import localeMessages from './vue-i18n-locales.generated';

export function installAppPlugins(app: App, locale: string): App {
    // A fresh instance per call, never one shared at module scope. On the SSR
    // server this module is loaded once and serves every request, so a shared
    // instance would hold whichever locale rendered last and hand it to the
    // next visitor, concurrently. Per call means per request there.
    const i18n = createI18n({
        legacy: false,
        locale,
        fallbackLocale: 'en',
        messages: localeMessages,
    });

    return app
        .mixin({
            methods: {
                getRarityColor,
                replaceIcons,
            },
        })
        .use(i18n);
}

// The document title, identical on both sides so the server's HTML and the
// client's first render agree. The server used to append " - <app>" to an
// empty title too, giving " - Monster Hunter" where the client gave the bare
// name.
export function appTitle(title: string, appName: string): string {
    return title ? `${title} - ${appName}` : appName;
}
