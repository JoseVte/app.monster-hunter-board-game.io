<script setup>
import {Link} from "@inertiajs/vue3";
import ButtonDark from "@/Layouts/Partials/ButtonDark.vue";
import LocaleDropdown from "@/Components/Layout/LocaleDropdown.vue";
import LoginIcon from "@/Components/Icons/LoginIcon.vue";

defineProps({
    canRegister: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div
            class="fixed top-0 z-50 flex w-full items-center justify-between gap-6 border-b border-gray-300 bg-white p-4 text-right sm:w-auto sm:border-x sm:py-2 sm:right-6 dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="block sm:hidden">
                <slot name="logo" />
            </div>

            <div class="flex justify-between items-center">
                <LocaleDropdown />
                <ButtonDark />

                <Link
                    v-if="!canRegister"
                    :href="route('login')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-solid focus:outline-2 focus:rounded-xs focus:outline-primary-500"
                >
                    <LoginIcon class="h-6 w-6 block lg:hidden" />
                    <span class="hidden lg:block">{{ $t('Log in') }}</span>
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-solid focus:outline-2 focus:rounded-xs focus:outline-primary-500"
                >
                    <LoginIcon class="h-6 w-6 block lg:hidden" />
                    <span class="hidden lg:block">{{ $t('Register') }}</span>
                </Link>
            </div>
        </div>

        <div class="hidden sm:block">
            <slot name="logo" />
        </div>

        <div class="mh-frame mt-32 w-full bg-white px-6 py-5 sm:mt-6 sm:max-w-md dark:bg-gray-800">
            <slot />
        </div>
    </div>
</template>
