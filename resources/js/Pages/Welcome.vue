<script setup>
import _ from "lodash";
import {Head, Link} from '@inertiajs/vue3';
import {computed, onMounted, ref} from "vue";
import {useI18n} from "vue-i18n";
import Typed from 'typed.js';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ButtonDark from "@/Layouts/Partials/ButtonDark.vue";
import campaignEn from '~/screens/campaign-en.webp'
import campaignEs from '~/screens/campaign-es.webp'
import wikiEn from '~/screens/wiki-en.webp'
import wikiEs from '~/screens/wiki-es.webp'
import hunterEn from '~/screens/hunter-en.webp'
import hunterEs from '~/screens/hunter-es.webp'
import heroImg1 from '~/hero/1.webp'
import heroImg2 from '~/hero/2.webp'
import heroImg3 from '~/hero/3.webp'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Dashboard from "@/Components/Icons/Dashboard.vue";
import LoginIcon from "@/Components/Icons/LoginIcon.vue";
import LocaleDropdown from "@/Components/Layout/LocaleDropdown.vue";
import LegalFooter from "@/Components/Layout/LegalFooter.vue";
const { t, locale } = useI18n({ useScope: 'global' })

// The screenshots show the app's own interface, so an English one on a Spanish
// page reads as a different product. Each is captured in both languages and
// picked here; anything other than the two the app speaks falls back to
// English, which is also vue-i18n's fallbackLocale.
const screens = {
    campaign: { en: campaignEn, es: campaignEs },
    hunter: { en: hunterEn, es: hunterEs },
    wiki: { en: wikiEn, es: wikiEs },
};

const screen = (name) => computed(() => screens[name][locale.value] ?? screens[name].en);

const campaignImg = screen('campaign');
const hunterImg = screen('hunter');
const wikiImg = screen('wiki');

// One of the three at random, as it always was. Only the hero draws from this
// set now, so it can no longer pick the same picture as a section below it.
const heroImg = _.sample([heroImg1, heroImg2, heroImg3]);

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
});

const typing = ref(null);
onMounted(() => {
    new Typed(typing.value, {
        strings: [
            t('manage your campaigns'),
            t('search items, weapons, etc.'),
            t('manage your hunter')
        ],
        typeSpeed: 100,
        backSpeed: 60,
        showCursor: true,
        cursorChar: '_',
        loop: true
    });
});
</script>

<template>
    <!--
        The title alone. app.js appends " - <app name>" to whatever this is, and
        the description lives in the Blade layout: @inertiaHead is inserted after
        the static tags, so a meta given here would be the second one on the page
        and a crawler reads the first.
    -->
    <Head :title="$t('Campaign tracker')" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 dark:text-white selection:bg-primary-500 selection:text-white">
        <div
            class="fixed top-0 z-50 flex w-full items-center justify-between gap-6 border-b border-gray-300 bg-white p-4 text-right sm:w-auto sm:border-x sm:py-2 sm:right-6 dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="flex justify-between items-center">
                <LocaleDropdown />
                <ButtonDark />
            </div>

            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                :title="$t('Dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-solid focus:outline-2 focus:rounded-xs focus:outline-primary-500"
            >
                <Dashboard class="h-6 w-6 block lg:hidden" />
                <span class="hidden lg:block">{{ $t('Dashboard') }}</span>
            </Link>

            <template v-else>
                <div class="flex gap-4">
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        :title="$t('Log in')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-solid focus:outline-2 focus:rounded-xs focus:outline-primary-500"
                    >
                        <LoginIcon class="h-6 w-6 block lg:hidden" />
                        <span class="hidden lg:block">{{ $t('Log in') }}</span>
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        :title="$t('Register')"
                        class="ml-4 hidden lg:block font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-solid focus:outline-2 focus:rounded-xs focus:outline-primary-500"
                    >
                        {{ $t('Register') }}
                    </Link>
                </div>
            </template>
        </div>

        <div class="mt-17.5 sm:mt-0 w-full">
            <section class="relative w-full">
                <!--
                    Stills from Capcom's video game, kept at the owner's
                    decision after being flagged: they are somebody else's
                    artwork on a public page, which is the same objection that
                    keeps a portrait off the monster card view. Two alternatives
                    were tried and rejected. A screenshot of this app does not
                    work as a backdrop, blurred enough to sit behind text it is
                    invisible under the veil and legible enough to see it reads
                    as a dimmed screenshot.
                -->
                <div
                    class="bg-center bg-cover bg-no-repeat absolute inset-0 z-0"
                    :style="{backgroundImage: 'url('+heroImg+')'}"
                >
                    <div class="w-full h-full bg-black opacity-50" />
                </div>
                <ApplicationLogo class="relative block z-50 h-16 w-16 min-h-16 min-w-16 text-white top-6 ml-6 lg:ml-8" />

                <div class="max-w-7xl mx-auto relative mt-16 z-40 text-white md:text-lg">
                    <div class="w-full m-auto md:w-187.5 lg:w-242.5 xl:w-292.5">
                        <div class="flex flex-col items-center gap-10 md:gap-4 h-[85vh]">
                            <div class="pt-10 md:pt-0 w-full">
                                <h1 class="text-[40px] leading-8 md:text-[65px] md:leading-tight font-semibold text-center">
                                    {{ $t('Monster Hunter World: Board Game') }}
                                </h1>
                            </div>
                            <div class="flex flex-col sm:items-center sm:justify-between sm:flex-row gap-4 w-full h-full">
                                <div class="w-full md:w-1/2">
                                    <div class="text-center md:text-left mb-8">
                                        <h2 class="text-[32px] leading-8 xl:text-[50px] xl:leading-tight font-semibold">
                                            <span>{{ $t('Website designed for') }}</span><br>
                                            <span ref="typing" />
                                        </h2>
                                    </div>
                                </div>
                                <div class="px-4 md:px-0 w-full md:w-1/2 lg:pl-1/12 lg:w-5/12">
                                    <div class="mh-frame mx-auto w-fit bg-white p-6 text-gray-700 xl:p-8 dark:bg-gray-800">
                                        <div
                                            v-if="$page.props.auth.user"
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <Link :href="route('dashboard')">
                                                <PrimaryButton>
                                                    <Dashboard class="h-6 w-6 mr-4" />
                                                    {{ $t('Go to dashboard') }}
                                                </PrimaryButton>
                                            </Link>
                                        </div>
                                        <div
                                            v-else
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <Link
                                                v-if="canLogin"
                                                :href="route('login')"
                                            >
                                                <PrimaryButton>
                                                    {{ $t('Log in') }}
                                                </PrimaryButton>
                                            </Link>
                                            <div
                                                v-if="canLogin && canRegister"
                                                class="flex w-full flex-row items-center justify-between py-4 text-gray-500"
                                            >
                                                <hr class="w-full mr-2">
                                                {{ $t('Or') }}
                                                <hr class="w-full ml-2">
                                            </div>
                                            <Link
                                                v-if="canRegister"
                                                :href="route('register')"
                                            >
                                                <PrimaryButton>
                                                    {{ $t('Register') }}
                                                </PrimaryButton>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="section h-[85vh] relative flex flex-col items-center py-6 md:py-0 lg:flex-row-reverse md:text-lg max-w-7xl mx-auto mt-16"
            >
                <div
                    class="bg-size-[65%] lg:bg-cover xl:bg-contain bg-center lg:bg-left bg-no-repeat w-full min-h-55 mb-8 sm:min-h-65 md:flex md:items-center md:w-full md:min-h-[50%] lg:basis-1/2 lg:mb-0 lg:h-full"
                    :style="{backgroundImage: 'url('+campaignImg+')'}"
                />
                <div class="w-full md:w-162.5 lg:w-121.25 xl:w-146.25">
                    <div class="px-2.5 md:px-0 lg:px-6 lg:basis-1/2 xl:ml-auto xl:w-11/12">
                        <div class="relative pb-3 mb-4 after:content-[''] after:w-[32px] lg:after:w-10 after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-0.5">
                            <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                                {{ $t('Powerful backend dashboard that gives you full control') }}
                            </h2>
                        </div>
                        <p>{{ $t('Our dashboard gives you full control over your campaigns and hunters. From within the system you can create/edit campaign and craft your hunter weapons/armors.') }}</p>
                    </div>
                </div>
            </section>

            <section
                class="section h-screen relative flex flex-col items-center py-6 md:py-0 lg:flex-row md:text-lg max-w-full mx-auto mt-16"
            >
                <div
                    class="bg-cover bg-center w-full min-h-55 mb-8 sm:min-h-65 md:flex md:items-center md:w-full md:min-h-[50%] lg:basis-1/2 lg:mb-0 lg:h-full"
                    :style="{backgroundImage: 'url('+hunterImg+')'}"
                />
                <div class="w-full md:w-162.5 lg:w-121.25 xl:w-146.25">
                    <div class="px-2.5 md:px-0 lg:px-6 lg:basis-1/2 xl:ml-auto xl:w-11/12">
                        <div class="relative pb-3 mb-4 after:content-[''] after:w-8 lg:after:w-10 after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-0.5">
                            <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                                {{ $t('Do it in 3 easy steps') }}
                            </h2>
                        </div>
                        <div class="counter-list flex flex-col gap-2">
                            <!--
                                Step one depends on whether anyone can sign up.
                                With AUTH_CAN_REGISTER off, which is the default,
                                there is no registration form and no link to one,
                                so telling a visitor to fill it in sends them
                                looking for a page that does not exist.
                            -->
                            <div class="flex flex-col">
                                <div class="text-[22px] font-bold text-gray-900 dark:text-gray-100">
                                    {{ canRegister ? $t('Complete registration form') : $t('Get an invitation') }}
                                </div>
                                <p class="text-gray-500">
                                    {{ canRegister
                                        ? $t('Complete the registration form. Our team will be in touch to activate your account.')
                                        : $t('The app is invitation only for now. Ask somebody already using it to send you one.') }}
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <div class="text-[22px] font-bold text-gray-900 dark:text-gray-100">
                                    {{ $t('Create a campaign') }}
                                </div>
                                <p class="text-gray-500">
                                    {{ $t('Once you have an account, you can create your first Monster Hunter campaign.') }}
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <div class="text-[22px] font-bold text-gray-900 dark:text-gray-100">
                                    {{ $t('Register the hunters') }}
                                </div>
                                <p class="text-gray-500">
                                    {{ $t('Add the hunters to the campaign to save your progress and your friends/hunters.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="section h-[85vh] relative flex flex-col items-center py-6 md:py-0 lg:flex-row-reverse md:text-lg max-w-7xl mx-auto mt-16"
            >
                <div
                    class="bg-cover bg-center w-full min-h-55 mb-8 sm:min-h-65 md:flex md:items-center md:w-full md:min-h-[50%] lg:basis-1/2 lg:mb-0 lg:h-full"
                    :style="{backgroundImage: 'url('+wikiImg+')'}"
                />
                <div class="w-full md:w-162.5 lg:w-121.25 xl:w-146.25">
                    <div class="px-2.5 md:px-0 lg:px-6 lg:basis-1/2 xl:ml-auto xl:w-11/12">
                        <div class="relative pb-3 mb-4 after:content-[''] after:w-8 lg:after:w-10 after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-0.5">
                            <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                                {{ $t('The whole box, looked up in seconds') }}
                            </h2>
                        </div>
                        <p class="mb-4">
                            {{ $t('Every monster, weapon, armour and item from the base game and the expansions, in both languages. Filter by monster, expansion or rarity and find the piece you are arguing about without emptying the box on the table.') }}
                        </p>
                        <ul class="flex flex-col gap-2 text-gray-500">
                            <li>{{ $t('Follow a weapon up its crafting tree and see what each upgrade costs before you spend it.') }}</li>
                            <li>{{ $t('Read a monster like its card: difficulty tiers, resistances, body parts and the reward table.') }}</li>
                            <li>{{ $t('Check what an armour set gives you, and which pieces you are still missing for the bonus.') }}</li>
                        </ul>
                    </div>
                </div>
            </section>

            <LegalFooter />
        </div>
    </div>
</template>
