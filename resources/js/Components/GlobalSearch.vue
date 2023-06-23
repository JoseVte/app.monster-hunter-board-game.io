<script setup>

import {ref, watch} from "vue";
import { vOnClickOutside } from '@vueuse/components';
import axios from "axios";
import TextInput from "@/Components/Form/TextInput.vue";
import SearchIcon from "@/Components/Icons/SearchIcon.vue";

const openSearch = ref(false);
const openSearchResults = ref(true);
const searchText = ref('');
const searchResults = ref([]);

const closeResults = () => openSearchResults.value = false;

watch(searchText, (after) => {
    axios.get(route('global-search'), {params: {keyword: after}})
        .then(res => {
            searchResults.value = res.data
            openSearchResults.value = true;
        })
        .catch(error => console.error(error));
})
</script>

<template>
    <div
        v-on-click-outside="closeResults"
        class="-my-px sm:px-2 flex items-center border-r border-gray-200 dark:border-gray-800 relative"
    >
        <button
            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out h-full capitalize"
            type="button"
            @click="openSearch = !openSearch"
        >
            <SearchIcon class="h-5 w-5 mx-2 text-black dark:text-white" />
            <span class="sr-only">{{ $t('Search') }}</span>
        </button>

        <Transition
            name="search-animation"
            enter-active-class="transition ease-out duration-400"
            enter-from-class="opacity-0 scale-90"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-90"
        >
            <div v-if="openSearch">
                <TextInput
                    id="search"
                    v-model="searchText"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="search"
                    :placeholder="$t('Search')"
                    @focusin="openSearchResults = true"
                />
            </div>
        </Transition>

        <ul
            v-if="searchResults.length > 0 && openSearchResults"
            class="absolute top-16 left-11 w-80 bg-white border-2 border-gray-200 dark:bg-gray-800 dark:border-gray-700 rounded z-50"
        >
            <li
                v-for="result in searchResults"
                :key="`${result.id}-${result.class}`"
                class="result"
            >
                <a
                    class="block px-3 py-2 bg-white hover:bg-gray-50 dark:text-white dark:bg-gray-800 dark:hover:bg-gray-700 transition duration-150 ease-in-out"
                    :href="result.url"
                    v-html="result.name"
                />
            </li>
        </ul>
    </div>
</template>

<style>
    .result em {
        @apply not-italic font-bold underline;
    }
</style>
