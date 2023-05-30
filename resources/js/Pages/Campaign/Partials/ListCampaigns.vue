<script setup>
import {Link} from "@inertiajs/vue3";
import Potion from "@/Components/Icons/Potion.vue";
import Calendar from "@/Components/Icons/Calendar.vue";

defineProps({
    campaigns: Array
})

const strLimit = function (value, size) {
    if (!value) return '';
    value = value.toString();

    if (value.length <= size) {
        return value;
    }
    return value.substring(0, size) + '...';
}
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
            v-for="campaign in campaigns"
            :key="campaign.id"
            class="p-6 lg:p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
        >
            <Link
                :href="route('campaigns.show', campaign)"
                class="flex justify-between"
            >
                <div class="flex flex-col">
                    <div class="flex items-center">
                        <img
                            class="w-6 h-6 rounded-full object-cover"
                            :src="campaign.team.owner.profile_photo_url"
                            :alt="campaign.team.owner.name"
                        >

                        <div class="ml-2 leading-tight text-xs">
                            <div class="text-gray-900 dark:text-white">
                                {{ campaign.team.name }}
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-2 text-2xl font-medium text-gray-900 dark:text-white">
                        {{ campaign.name }}
                    </h2>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ strLimit(campaign.description, 20) }}
                    </p>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 flex flex-col gap-1 items-center justify-center">
                        <Potion class="w-6 h-6" />
                        <span class="text-xxs">{{ campaign.health_potions }} / 3</span>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 flex flex-col gap-1 items-center justify-center">
                        <Calendar class="w-6 h-6" />
                        <span class="text-xxs">{{ campaign.days_count }} / {{ campaign.max_days }}</span>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<style scoped>

</style>
