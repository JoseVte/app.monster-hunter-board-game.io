import './bootstrap';
import '../css/app.css';

import { createI18n } from 'vue-i18n';
import { createApp, h } from 'vue';
import Vue3Storage, {StorageType} from "vue3-storage";
import { VueReCaptcha } from 'vue-recaptcha-v3'
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { useRegisterSW } from 'virtual:pwa-register/vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { replaceIcons } from './icons';
import { getRarityColor } from './rarity';
import { startAnalytics } from './analytics';
import localeMessages from "./vue-i18n-locales.generated";
useRegisterSW();
startAnalytics();
const appName = window.document.getElementsByTagName('title')[0]?.innerText || import.meta.env.APP_NAME;

createInertiaApp({
    title: (title) => {
        if (title) {
            return  `${title} - ${appName}`
        }

        return  appName
    },
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const i18n = createI18n({
            legacy: false,
            locale: props.initialPage.props.locale, // user locale by props
            fallbackLocale: "en", // set fallback locale
            messages: localeMessages, // set locale messages
        });

        const recaptchaSiteKey = props.initialPage.props.recaptcha_site_key;

        return createApp({ render: () => h(App, props) })
            .use({
                install: async (app) => {
                    app.mixin({
                        methods: {
                            getRarityColor: getRarityColor,
                            replaceIcons: replaceIcons,
                        }
                    })
                }
            })
            .use(Vue3Storage, {
                namespace: 'mh_',
                storage: StorageType.Session
            })
            .use(plugin)
            .use(VueReCaptcha, {
                siteKey: recaptchaSiteKey,
                loaderOptions: {
                    autoHideBadge: true
                }
            } )
            .use(i18n)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
