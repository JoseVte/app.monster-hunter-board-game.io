<script setup>
import _ from "lodash";
import {Head, Link} from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
import {useI18n} from "vue-i18n";
import Typed from 'typed.js';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ButtonDark from "@/Layouts/Partials/ButtonDark.vue";
import image1 from '~/hero/1.jpg'
import image2 from '~/hero/2.jpg'
import image3 from '~/hero/3.jpg'
import dashboardImg from '~/dashboard.png'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Dashboard from "@/Components/Icons/Dashboard.vue";
import LoginIcon from "@/Components/Icons/LoginIcon.vue";
import LocaleDropdown from "@/Components/Layout/LocaleDropdown.vue";
const { t } = useI18n({ useScope: 'global' })

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    status: String,
});

const heroImg = _.sample([
    image1,
    image2,
    image3,
])

// TODO: use in-game images
const stepImg = _.sample([
    image1,
    image2,
    image3,
])

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
    <Head :title="$t('Monster Hunter World: Board Game')" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 dark:text-white selection:bg-primary-500 selection:text-white">
        <div
            class="fixed z-50 w-full sm:w-auto top-0 sm:right-6 flex gap-6 justify-between items-center p-4 sm:py-2 text-right bg-white dark:bg-gray-800 sm:rounded-b-xl"
        >
            <div class="flex justify-between items-center">
                <LocaleDropdown />
                <ButtonDark />
            </div>

            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500"
            >
                <Dashboard class="h-6 w-6 block lg:hidden" />
                <span class="hidden lg:block">{{ $t('Dashboard') }}</span>
            </Link>

            <template v-else>
                <div class="flex gap-4">
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500"
                    >
                        <LoginIcon class="h-6 w-6 block lg:hidden" />
                        <span class="hidden lg:block">{{ $t('Log in') }}</span>
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ml-4 hidden lg:block font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500"
                    >
                        {{ $t('Register') }}
                    </Link>
                </div>
            </template>
        </div>

        <div class="mt-[70px] sm:mt-0 w-full">
            <section class="relative w-full">
                <div
                    class="bg-center bg-cover bg-no-repeat absolute inset-0 z-0"
                    :style="{backgroundImage: 'url('+heroImg+')'}"
                >
                    <div class="w-full h-full bg-black opacity-50" />
                </div>
                <ApplicationLogo class="relative block z-50 h-16 w-16 min-h-16 min-w-16 text-white top-6 ml-6 lg:ml-8" />

                <div class="max-w-7xl mx-auto relative mt-16 z-40 text-white md:text-lg">
                    <div class="w-full m-auto md:w-[750px] lg:w-[970px] xl:w-[1170px]">
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
                                    <div class="p-6 xl:p-8 bg-white w-fit mx-auto dark:bg-gray-800 rounded text-gray-700 sing-up">
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
                                            <div class="flex w-full flex-row items-center justify-between py-4 text-gray-500">
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
                    class="bg-[length:65%] lg:bg-cover xl:bg-contain bg-center lg:bg-left bg-no-repeat w-full min-h-[220px] mb-8 sm:min-h-[260px] md:flex md:items-center md:w-full md:min-h-[50%] lg:basis-1/2 lg:mb-0 lg:h-full"
                    :style="{backgroundImage: 'url('+dashboardImg+')'}"
                />
                <div class="w-full md:w-[650px] lg:w-[485px] xl:w-[585px]">
                    <div class="px-2.5 md:px-0 lg:px-6 lg:basis-1/2 xl:ml-auto xl:w-11/12">
                        <div class="relative pb-3 mb-4 after:content-[''] after:w-[32px] lg:after:w-[40px] after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-[2px]">
                            <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                                {{ $t('Powerful backend dashboard that gives you full control') }}
                            </h2>
                        </div>
                        <p>{{ $t('Our powerful dashboard allows gives you full control to manage your campaigns and hunters. From within the system you can create/edit campaign and craft your hunter weapons/armors.') }}</p>
                    </div>
                </div>
            </section>

            <section
                class="section h-[100vh] relative flex flex-col items-center py-6 md:py-0 lg:flex-row md:text-lg max-w-full mx-auto mt-16"
            >
                <div
                    class="bg-cover bg-center w-full min-h-[220px] mb-8 sm:min-h-[260px] md:flex md:items-center md:w-full md:min-h-[50%] lg:basis-1/2 lg:mb-0 lg:h-full"
                    :style="{backgroundImage: 'url('+stepImg+')'}"
                />
                <div class="w-full md:w-[650px] lg:w-[485px] xl:w-[585px]">
                    <div class="px-2.5 md:px-0 lg:px-6 lg:basis-1/2 xl:ml-auto xl:w-11/12">
                        <div class="relative pb-3 mb-4 after:content-[''] after:w-[32px] lg:after:w-[40px] after:absolute after:left-0 after:bottom-0 after:bg-primary-600 after:h-[2px]">
                            <h2 class="text-[28px] leading-tight lg:text-[46px] font-semibold">
                                {{ $t('Do it in 3 easy steps') }}
                            </h2>
                        </div>
                        <div class="counter-list flex flex-col gap-2">
                            <div class="flex flex-col">
                                <div class="text-[22px] font-bold text-gray-900 dark:text-gray-100">
                                    {{ $t('Complete registration form') }}
                                </div>
                                <p class="text-gray-500">
                                    {{ $t('Complete the registration form. Our team will be in touch to activate your account.') }}
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <div class="text-[22px] font-bold text-gray-900 dark:text-gray-100">
                                    {{ $t('Create a campaign') }}
                                </div>
                                <p class="text-gray-500">
                                    {{ $t('Once your registration is complete, you can create your first Monster Hunter campaign.') }}
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
        </div>
    </div>
</template>
