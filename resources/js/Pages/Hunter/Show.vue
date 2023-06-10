<script setup>
import {Link} from "@inertiajs/vue3";
import _ from "lodash";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Edit from "@/Components/Icons/Edit.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import UpdateCountItemForm from "@/Pages/Hunter/Partials/UpdateCountItemForm.vue";

const props = defineProps({
    campaign: Object,
    hunter: Object,
    user: Object,
    commonItems: Array,
});

const chunkArray = (arr, n) => {
    const chunkLength = Math.max(arr.length / n, 1);
    const chunks = [];
    for (let i = 0; i < n; i++) {
        if (chunkLength * (i + 1) <= arr.length) chunks.push(arr.slice(chunkLength * i, chunkLength * (i + 1)));
    }
    return chunks;
}

const countItem = (item) => {
    const hunterItemCount = _.find(props.hunter.items, (hunterItem) => {
        return item.id === hunterItem.pivot.item_id
    });
    if (hunterItemCount) {
        return hunterItemCount.pivot.number;
    }

    return 0;
}
</script>

<template>
    <AppLayout :title="hunter.name">
        <template #header>
            <Breadcrumb
                :current-title="hunter.name"
                :breadcrumbs="[
                    { url: route('campaigns.show', campaign), title: campaign.name },
                ]"
                :icon="WeaponsIcon"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                    <img
                        :src="user.profile_photo_url"
                        :alt="user.name"
                        class="relative inline-block h-20 w-20 rounded-full ring-2 ring-white dark:ring-gray-800 hover:ring-gray-200 dark:hover:ring-gray-600"
                    >
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 w-full relative">
                        <h1 class="text-gray-800 dark:text-white text-2xl">
                            {{ hunter.name }}
                        </h1>
                        <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                            {{ user.name }}
                        </h2>
                        <Link
                            :href="route('campaigns.show', campaign)"
                            class="text-gray-600 dark:text-gray-400 text-xl"
                        >
                            {{ campaign.name }}
                        </Link>
                        <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                            {{ hunter.palico ? hunter.palico.name : '-' }}
                        </h2>
                        <div class="absolute top-0 right-0">
                            <Link :href="route('campaigns.hunters.edit', [campaign, hunter])">
                                <Edit class="h-4 w-4 text-gray-700 dark:text-gray-300" />
                            </Link>
                        </div>
                    </div>
                </div>

                <SectionBorder />

                <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4">
                    <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                        {{ $t('Common Bones, Ores and Hides') }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div
                            v-for="(chunkItems, index) in chunkArray(commonItems, 2)"
                            :key="index"
                        >
                            <UpdateCountItemForm
                                v-for="item in chunkItems"
                                :key="item.id"
                                :campaign="campaign"
                                :hunter="hunter"
                                :item="item"
                                :count-item="countItem(item)"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
