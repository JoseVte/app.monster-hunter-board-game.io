<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    items: Array,
    pagination: {
        type: Object,
        validate: {
            from: Number,
            to: Number,
            currentPage: Number,
            lastPage: Number,
            total: Number,
            prevPageUrl: String,
            nextPageUrl: String,
        }
    }
})
</script>

<template>
    <div
        v-if="items.length"
        class="flex flex-col items-center"
    >
        <!-- Help text -->
        <span class="text-sm text-gray-700 dark:text-gray-400">
            {{ $t('pagination.showing') }} <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.from }}</span> {{ $t('pagination.to') }} <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.to }}</span> {{ $t('pagination.of') }} <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</span> {{ $t('pagination.entries') }}
        </span>
        <!-- Buttons -->
        <div class="inline-flex mt-2 xs:mt-0">
            <Link
                v-if="pagination.currentPage > 1"
                :href="pagination.prevPageUrl"
                class="inline-flex items-center px-4 py-2 mr-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >
                <svg
                    aria-hidden="true"
                    class="w-5 h-5 mr-2"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                ><path
                    fill-rule="evenodd"
                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                    clip-rule="evenodd"
                /></svg>
                {{ $t('pagination.previous') }}
            </Link>
            <Link
                v-if="pagination.currentPage < pagination.lastPage"
                :href="pagination.nextPageUrl"
                class="inline-flex items-center px-4 py-2 mr-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >
                {{ $t('pagination.next') }}
                <svg
                    aria-hidden="true"
                    class="w-5 h-5 ml-2"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                ><path
                    fill-rule="evenodd"
                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                /></svg>
            </Link>
        </div>
    </div>
</template>

<style scoped>

</style>
