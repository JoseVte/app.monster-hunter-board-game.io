<script setup>
import ButtonDark from "@/Layouts/Partials/ButtonDark.vue";
import LocaleDropdown from "@/Components/Layout/LocaleDropdown.vue";
import LoginIcon from "@/Components/Icons/LoginIcon.vue";
import {Link} from "@inertiajs/vue3";

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
            class="fixed z-50 w-full sm:w-auto top-0 sm:right-6 flex gap-6 justify-between items-center p-4 sm:py-2 text-right bg-white dark:bg-gray-800 sm:rounded-b-xl"
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
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500"
                >
                    <LoginIcon class="h-6 w-6 block lg:hidden" />
                    <span class="hidden lg:block">{{ $t('Log in') }}</span>
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500"
                >
                    <LoginIcon class="h-6 w-6 block lg:hidden" />
                    <span class="hidden lg:block">{{ $t('Register') }}</span>
                </Link>
            </div>
        </div>

        <div class="hidden sm:block">
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-32 sm:mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
