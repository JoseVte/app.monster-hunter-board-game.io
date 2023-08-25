import './bootstrap';
import '../css/app.css';

import VueGtag from "vue-gtag";
import { createI18n } from 'vue-i18n';
import { createApp, h } from 'vue';
import Vue3Storage, {StorageType} from "vue3-storage";
import { VueReCaptcha } from 'vue-recaptcha-v3'
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { useRegisterSW } from 'virtual:pwa-register/vue'
import { isString } from "lodash";
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import localeMessages from "./vue-i18n-locales.generated";
import fire from '~/types/fire.png';
import water from '~/types/water.png';
import thunder from '~/types/thunder.png';
import ice from '~/types/ice.png';
import dragon from '~/types/dragon.png';
import damageAttack from '~/icons/damage-attack.png';
import comboAttack from '~/icons/combo-attack.png';
import defense from '~/icons/defense.png';
import breakIcon from '~/icons/break.svg';
import poison from '~/icons/poison.webp';
import stun from '~/icons/stun.webp';
import sleep from '~/icons/sleep.svg';
useRegisterSW();
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

                    const replaceIcons = (text) => {
                        if (isString(text)) {
                            return text.replaceAll(':fire_icon:', '<img src="'+fire+'" alt="Fire" class="h-4 w-4 inline" >')
                                .replaceAll(':water_icon:', '<img src="'+water+'" alt="Fire" class="h-4 w-4 inline" >')
                                .replaceAll(':ice_icon:', '<img src="'+ice+'" alt="Fire" class="h-4 w-4 inline" >')
                                .replaceAll(':thunder_icon:', '<img src="'+thunder+'" alt="Fire" class="h-4 w-4 inline" >')
                                .replaceAll(':dragon_icon:', '<img src="'+dragon+'" alt="Fire" class="h-4 w-4 inline" >')
                                .replaceAll(':dragon_icon:', '<img src="'+dragon+'" alt="Fire" class="h-4 w-4 inline" >')
                                .replaceAll(':damage_attack_icon:', '<img src="'+damageAttack+'" alt="Damage Attack" class="h-4 w-4 inline" >')
                                .replaceAll(':combo_attack_icon:', '<img src="'+comboAttack+'" alt="Combo Attack" class="h-4 w-4 inline" >')
                                .replaceAll(':defense_icon:', '<img src="'+defense+'" alt="Defense" class="h-4 w-4 inline" >')
                                .replaceAll(':break_icon:', '<img src="'+breakIcon+'" alt="Break" class="h-4 w-4 inline" >')
                                .replaceAll(':poison_icon:', '<img src="'+poison+'" alt="Poison" class="h-4 w-4 inline" >')
                                .replaceAll(':stun_icon:', '<img src="'+stun+'" alt="Stun" class="h-4 w-4 inline" >')
                                .replaceAll(':sleep_icon:', '<img src="'+sleep+'" alt="Sleep" class="h-4 w-4 inline" >')
                        }

                        return text;
                    }

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
            .use(VueGtag, {
                bootstrap: import.meta.env.PROD,
                config: {
                    id: import.meta.env.VITE_GOOGLE_ANALYTICS_KEY,
                    params: {
                        anonymize_ip: true
                    }
                }
            })
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
