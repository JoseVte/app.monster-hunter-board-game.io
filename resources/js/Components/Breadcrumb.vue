<script setup>
import {Link} from '@inertiajs/vue3';
import Dashboard from "@/Components/Icons/Dashboard.vue";

defineProps({
    currentTitle: String,
    icon: [Object, String],
    breadcrumbs: Array,
});
</script>

<template>
    <nav
        class="flex"
        aria-label="Breadcrumb"
    >
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <Link
                        :href="route('dashboard')"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                    >
                        <Dashboard class="w-4 h-4" />
                    </Link>
                </div>
            </li>
            <li
                v-for="(breadcrumb, index) in breadcrumbs"
                :key="index"
                aria-current="page"
            >
                <div class="flex items-center">
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6 text-gray-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    ><path
                        fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                    /></svg>
                    <Link
                        :href="breadcrumb.url"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white flex items-center"
                    >
                        <component
                            :is="breadcrumb.icon"
                            v-if="breadcrumb.icon"
                            class="h-4 w-4 text-gray-800 dark:text-gray-200 mr-2"
                        />
                        {{ breadcrumb.title }}
                    </Link>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6 text-gray-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    ><path
                        fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                    /></svg>
                    <h2 class="mx-1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight md:mx-2 flex items-center">
                        <component
                            :is="icon"
                            v-if="icon"
                            class="h-6 w-6 text-gray-800 dark:text-gray-200 mr-2"
                        />
                        {{ currentTitle }}
                    </h2>
                </div>
            </li>
        </ol>
    </nav>
</template>

