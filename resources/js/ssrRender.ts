// The SSR render itself, kept apart from `ssr.ts` so it can be called without
// starting a server: `createServer()` binds a port the moment it runs, which
// is fine for production and useless for a test. `ssr.ts` hands this to
// `createServer()` and does nothing else.
import {createSSRApp, h, type DefineComponent} from 'vue';
import {renderToString} from '@vue/server-renderer';
import {createInertiaApp} from '@inertiajs/vue3';
import type {Page} from '@inertiajs/core';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import {appTitle, installAppPlugins} from './appPlugins';

export function renderPage(page: Page) {
    return createInertiaApp({
        page,
        render: renderToString,
        // `appName` comes with the page rather than from `process.env`: the
        // SSR process is started by a supervisor with no `.env` loaded, so the
        // environment variable this used to read was never there.
        title: (title) => appTitle(title, page.props.appName),
        resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
        setup({App, props, plugin}) {
            const app = createSSRApp({render: () => h(App, props)}).use(plugin);

            installAppPlugins(app, page.props.locale);

            // The browser reads Ziggy's route list from the global Blade's
            // `@routes` puts on the page; a Node process has no such global,
            // so the server takes it from the `ziggy` prop
            // `HandleInertiaRequests::share()` already sends on every request.
            return app.use(ZiggyVue, {
                ...page.props.ziggy,
                location: new URL(page.props.ziggy.location),
            });
        },
    });
}
