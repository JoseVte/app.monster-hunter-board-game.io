<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import Dashboard from "@/Components/Icons/Dashboard.vue";

const props = defineProps({
    currentTitle: String,
    icon: [Object, String, Function],
    breadcrumbs: Array,
});

const {t} = useI18n();

// A page with nothing above it in the trail (an empty breadcrumbs array) still
// needs somewhere for the mobile "back" link to go, so it falls back to the
// dashboard rather than disappearing.
const mobileBack = computed(() => props.breadcrumbs?.length
    ? props.breadcrumbs[props.breadcrumbs.length - 1]
    : {url: route('dashboard'), title: t('Home')});
</script>

<template>
    <nav
        class="flex"
        :aria-label="$t('Breadcrumb')"
    >
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="hidden sm:block">
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
                class="hidden sm:block"
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
                            class="h-4 w-4 mr-2"
                        />
                        {{ breadcrumb.title }}
                    </Link>
                </div>
            </li>
            <!-- The full trail wraps the current title onto its own line at
                 phone widths, so below sm it collapses to a single "back to
                 the nearest parent" link instead of the whole chain. -->
            <li class="sm:hidden">
                <Link
                    :href="mobileBack.url"
                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 dark:hover:text-white hover:text-blue-600"
                >
                    <svg
                        aria-hidden="true"
                        class="mr-1 h-4 w-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    ><path
                        fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                    /></svg>
                    {{ mobileBack.title }}
                </Link>
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
                            class="h-6 w-6 mr-2"
                        />
                        {{ currentTitle }}
                    </h2>
                </div>
            </li>
        </ol>
    </nav>
</template>

