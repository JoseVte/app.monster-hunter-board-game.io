import './bootstrap';
import '../css/app.css';

import { createI18n } from 'vue-i18n';

import { createApp, h } from 'vue';
import Vue3Storage, {StorageType} from "vue3-storage";
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import localeMessages from "./vue-i18n-locales.generated";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const i18n = createI18n({
            legacy: false,
            locale: props.initialPage.props.locale, // user locale by props
            fallbackLocale: "en", // set fallback locale
            messages: localeMessages, // set locale messages
        });

        return createApp({ render: () => h(App, props) })
            .use(Vue3Storage, {
                namespace: 'mh_',
                storage: StorageType.Session
            })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
