<script setup>
import {computed} from "vue";
import {useI18n} from "vue-i18n";
import {usePage} from "@inertiajs/vue3";
import enImg from "~/icons/en.svg";
import esImg from "~/icons/es.svg";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
const { locale } = useI18n({ useScope: 'global' })

locale.value = usePage().props.locale;

const localeImg = computed(() => {
    if (locale.value === 'en') {
        return enImg;
    }
    if (locale.value === 'es') {
        return esImg;
    }
    return enImg;
})
</script>

<template>
    <Dropdown
        align="right"
        width="auto"
    >
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    id="locale-dropdown-btn"
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                >
                    <img
                        class="w-4 h-4"
                        :src="localeImg"
                        alt="Locale flag"
                    >

                    <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                        />
                    </svg>
                </button>
            </span>
        </template>

        <template #content>
            <div class="w-20 sm:w-36">
                <!-- Locale Switcher -->
                <DropdownLink :href="route('language', 'en')">
                    <div class="flex items-center gap-2">
                        <img
                            class="w-4 h-4"
                            :src="enImg"
                            alt="Locale flag"
                        >

                        <div class="hidden sm:block">
                            {{ $t('English') }}
                        </div>

                        <svg
                            v-if="'en' === locale"
                            class="h-5 w-5 text-green-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </DropdownLink>
                <DropdownLink :href="route('language', 'es')">
                    <div class="flex items-center gap-2">
                        <img
                            class="w-4 h-4"
                            :src="esImg"
                            alt="Locale flag"
                        >

                        <div class="hidden sm:block">
                            {{ $t('Spanish') }}
                        </div>

                        <svg
                            v-if="'es' === locale"
                            class="h-5 w-5 text-green-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </DropdownLink>
            </div>
        </template>
    </Dropdown>
</template>

<style scoped>

</style>
