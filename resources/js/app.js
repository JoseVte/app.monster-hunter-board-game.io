import './bootstrap';
import '../css/app.css';

import { createI18n } from 'vue-i18n';

import { createApp, h } from 'vue';
import Vue3Storage, {StorageType} from "vue3-storage";
import { VueReCaptcha } from 'vue-recaptcha-v3'
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import localeMessages from "./vue-i18n-locales.generated";
import { useRegisterSW } from 'virtual:pwa-register/vue'
useRegisterSW();

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

        const recaptchaSiteKey = props.initialPage.props.recaptcha_site_key;

        return createApp({ render: () => h(App, props) })
            .use({
                install: async (app) => {
                    const getRarityColor = (rarity) => {
                        switch (rarity) {
                        case 1:
                            return 'text-gray-400 dark:text-gray-300';
                        case 2:
                            return 'text-lime-600';
                        case 3:
                            return 'text-green-600';
                        case 4:
                            return 'text-blue-500';
                        case 5:
                            return 'text-orange-500';
                        default:
                            return 'text-black dark:text-white';
                        }
                    };

                    app.mixin({
                        methods: {
                            getRarityColor: getRarityColor
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
