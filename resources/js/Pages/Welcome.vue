<script setup>
import _ from "lodash";
import {Head, Link} from '@inertiajs/vue3';
import {computed} from "vue";
import {useI18n} from "vue-i18n";
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
import PrimaryLink from "@/Components/PrimaryLink.vue";
import Dashboard from "@/Components/Icons/Dashboard.vue";
import LoginIcon from "@/Components/Icons/LoginIcon.vue";
import LocaleDropdown from "@/Components/Layout/LocaleDropdown.vue";
import LegalFooter from "@/Components/Layout/LegalFooter.vue";
const { locale } = useI18n({ useScope: 'global' })

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

</script>

<template>
    <!--
        The title alone. app.js appends " - <app name>" to whatever this is, and
        the description lives in the Blade layout: @inertiaHead is inserted after
        the static tags, so a meta given here would be the second one on the page
        and a crawler reads the first.
    -->
    <Head :title="$t('Campaign tracker')" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white selection:bg-primary-500 selection:text-white">
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
                                <h1 class="px-4 text-[40px] leading-tight md:text-[65px] font-semibold text-center">
                                    {{ $t('Monster Hunter World: Board Game') }}
                                </h1>
                            </div>
                            <div class="flex flex-col sm:items-center sm:justify-between sm:flex-row gap-4 w-full h-full">
                                <div class="w-full md:w-1/2">
                                    <!--
                                        A plain sentence, not the typing loop that used to
                                        sit here: it never stopped, ignored reduced motion,
                                        and left a screen reader reading half a word.
                                    -->
                                    <p class="px-4 md:px-0 text-center md:text-left mb-8 text-2xl leading-snug xl:text-4xl font-semibold">
                                        {{ $t('Your board game campaign without the paper sheet: the days, the hunts, your hunters and everything they carry.') }}
                                    </p>
                                </div>
                                <div class="px-4 md:px-0 w-full md:w-1/2 lg:pl-1/12 lg:w-5/12">
                                    <div class="mh-frame mx-auto w-fit bg-white p-6 text-gray-700 xl:p-8 dark:bg-gray-800">
                                        <div
                                            v-if="$page.props.auth.user"
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <PrimaryLink :href="route('dashboard')">
                                                <Dashboard class="h-6 w-6 mr-4" />
                                                {{ $t('Go to dashboard') }}
                                            </PrimaryLink>
                                        </div>
                                        <div
                                            v-else
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <PrimaryLink
                                                v-if="canLogin"
                                                :href="route('login')"
                                            >
                                                {{ $t('Log in') }}
                                            </PrimaryLink>
                                            <div
                                                v-if="canLogin && canRegister"
                                                class="flex w-full flex-row items-center justify-between py-4 text-gray-700 dark:text-gray-300"
                                            >
                                                <hr class="w-full mr-2">
                                                {{ $t('Or') }}
                                                <hr class="w-full ml-2">
                                            </div>
                                            <PrimaryLink
                                                v-if="canRegister"
                                                :href="route('register')"
                                            >
                                                {{ $t('Register') }}
                                            </PrimaryLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--
                Two screenshot sections, then the wiki with its list, then a
                text only band: the page used to repeat one composition four
                times. The screenshots are <img> with alt text rather than CSS
                backgrounds, so they size to their own aspect ratio on a phone
                instead of shrinking into a dark strip, and a screen reader is
                told what they show.
            -->
            <section class="max-w-7xl mx-auto mt-16 px-4 md:px-8 grid gap-8 items-center lg:grid-cols-2 lg:gap-12 md:text-lg">
                <img
                    :src="campaignImg"
                    :alt="$t('A campaign page: its description, the potion and day counters, and the hunters taking part.')"
                    width="2200"
                    height="1375"
                    loading="lazy"
                    class="mh-frame w-full h-auto"
                >
                <div>
                    <div class="relative pb-3 mb-4 after:content-[''] after:w-8 lg:after:w-10 after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-0.5">
                        <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                            {{ $t('Every day of the campaign, on one page') }}
                        </h2>
                    </div>
                    <p>{{ $t('Create the campaign with the boxes you play with, and the number of days follows from them. Then log each day: the monster you hunted and at what difficulty, or what each hunter did during downtime.') }}</p>
                </div>
            </section>

            <section class="max-w-7xl mx-auto mt-24 px-4 md:px-8 grid gap-8 items-center lg:grid-cols-2 lg:gap-12 md:text-lg">
                <img
                    :src="hunterImg"
                    :alt="$t('The armour tab of a hunter: total defence, active skills and the piece equipped in each slot.')"
                    width="2200"
                    height="1375"
                    loading="lazy"
                    class="mh-frame w-full h-auto lg:order-2"
                >
                <div class="lg:order-1">
                    <div class="relative pb-3 mb-4 after:content-[''] after:w-8 lg:after:w-10 after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-0.5">
                        <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                            {{ $t('The gear each hunter carries, and what it costs') }}
                        </h2>
                    </div>
                    <p>{{ $t('Every hunter keeps their own materials, weapons and armour. Craft from what they actually carry, and the app tells you which recipes they can afford.') }}</p>
                </div>
            </section>

            <section class="max-w-7xl mx-auto mt-24 px-4 md:px-8 grid gap-8 items-start lg:grid-cols-2 lg:gap-12 md:text-lg">
                <img
                    :src="wikiImg"
                    :alt="$t('The monster wiki: every monster with its category and the box it comes from.')"
                    width="2200"
                    height="1375"
                    loading="lazy"
                    class="mh-frame w-full h-auto"
                >
                <div>
                    <div class="relative pb-3 mb-4 after:content-[''] after:w-8 lg:after:w-10 after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-0.5">
                        <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                            {{ $t('The whole box, looked up in seconds') }}
                        </h2>
                    </div>
                    <p class="mb-4">
                        {{ $t('Every monster, weapon, armour and item from the base game and the expansions, in both languages. Filter by monster, expansion or rarity and find the piece you are arguing about without emptying the box on the table.') }}
                    </p>
                    <ul class="flex flex-col gap-2 text-gray-700 dark:text-gray-300 list-disc pl-5 marker:text-primary-600">
                        <li>{{ $t('Follow a weapon up its crafting tree and see what each upgrade costs before you spend it.') }}</li>
                        <li>{{ $t('Read a monster like its card: difficulty tiers, resistances, body parts and the reward table.') }}</li>
                        <li>{{ $t('Check what an armour set gives you, and which pieces you are still missing for the bonus.') }}</li>
                    </ul>
                </div>
            </section>

            <!--
                How to get in, as a short ordered list rather than the big
                numbered "3 easy steps" block. Step one depends on whether
                anyone can sign up: with AUTH_CAN_REGISTER off, which is the
                default, there is no registration form to send a visitor to.
            -->
            <section class="max-w-7xl mx-auto mt-24 mb-16 px-4 md:px-8 md:text-lg">
                <div class="mh-frame bg-white dark:bg-gray-800 p-6 md:p-10 grid gap-6 lg:grid-cols-[1fr_2fr] lg:gap-12">
                    <h2 class="text-[28px] leading-tight lg:text-[40px] font-semibold">
                        {{ $t('Before your first hunt') }}
                    </h2>
                    <ol class="flex flex-col gap-4 list-decimal pl-6 marker:font-bold marker:text-primary-600">
                        <li>
                            <span class="font-bold text-gray-900 dark:text-gray-100">
                                {{ canRegister ? $t('Create your account') : $t('Get an invitation') }}.
                            </span>
                            {{ ' ' }}
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ canRegister
                                    ? $t('Fill in the registration form and confirm your email address.')
                                    : $t('The app is invitation only for now. Ask somebody already using it to send you one.') }}
                            </span>
                        </li>
                        <li>
                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ $t('Create a campaign') }}.</span>
                            {{ ' ' }}
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ $t('Once you have an account, you can create your first Monster Hunter campaign.') }}
                            </span>
                        </li>
                        <li>
                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ $t('Add your hunters') }}.</span>
                            {{ ' ' }}
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ $t('One per player, so each keeps their own gear and progress.') }}
                            </span>
                        </li>
                    </ol>
                </div>
            </section>

            <LegalFooter />
        </div>
    </div>
</template>
