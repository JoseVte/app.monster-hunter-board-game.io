<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    title: String,
    description: String
});
</script>

<template>
    <Link
        :href="href"
        class="mh-card !flex-row items-center justify-between gap-4 bg-white p-6 transition-colors focus:outline-2 focus:outline-primary-500 focus:outline-solid dark:bg-gray-800"
    >
        <div>
            <div class="flex gap-6 items-center">
                <div class="p-3 bg-primary-50 dark:bg-primary-800/20 flex items-center justify-center rounded-full">
                    <slot name="icon" />
                </div>

                <h2
                    class="font-semibold text-gray-900 dark:text-white"
                    v-html="title"
                />
            </div>
        </div>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            class="self-center shrink-0 stroke-primary-500 w-6 h-6 lg:mx-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
            />
        </svg>
    </Link>
</template>

<style scoped>

</style>
