import './bootstrap';
import '../css/app.css';

import { createApp, h, type DefineComponent } from 'vue';
import Vue3Storage, {StorageType} from "vue3-storage";
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { useRegisterSW } from 'virtual:pwa-register/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { appTitle, installAppPlugins } from './appPlugins';
useRegisterSW();
const appName = window.document.getElementsByTagName('title')[0]?.innerText || import.meta.env.APP_NAME;

createInertiaApp({
    title: (title) => appTitle(title, appName),
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) }).use(plugin);

        // vue-i18n and the icon/rarity mixin, the same call `ssrRender.ts`
        // makes, so the two can no longer install different things.
        installAppPlugins(app, props.initialPage.props.locale);

        return app
            // Browser only: it wraps `sessionStorage`.
            .use(Vue3Storage, {
                namespace: 'mh_',
                storage: StorageType.Session
            })
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
