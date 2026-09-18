<script setup>
import {Link} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
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
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- A campaign reads as a card, the same one the weapons and armours are
             printed on, rather than a white panel with a shadow. -->
        <Card
            v-for="campaign in campaigns"
            :key="campaign.id"
            class="gap-3 p-4 sm:p-5"
        >
            <Link
                :href="route('campaigns.show', campaign)"
                class="flex cursor-pointer justify-between gap-3"
            >
                <span class="flex min-w-0 flex-col">
                    <span class="flex items-center gap-2">
                        <img
                            class="h-6 w-6 rounded-full object-cover"
                            :src="campaign.team.owner.profile_photo_url"
                            :alt="campaign.team.owner.name"
                        >
                        <span class="truncate text-xs text-gray-600 dark:text-gray-400">
                            {{ campaign.team.name }}
                        </span>
                    </span>

                    <span class="mh-card-name mt-2 text-xl">{{ campaign.name }}</span>

                    <span class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                        {{ strLimit(campaign.description_parsed, 20) }}
                    </span>
                </span>

                <span class="flex shrink-0 flex-col gap-2">
                    <span class="flex items-center gap-1.5">
                        <span class="flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                            <Potion class="h-4 w-4" />
                        </span>
                        <span class="mh-value">{{ campaign.health_potions }} / 3</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                            <Calendar class="h-4 w-4" />
                        </span>
                        <span class="mh-value">{{ campaign.days_count }} / {{ campaign.max_days }}</span>
                    </span>
                </span>
            </Link>

            <div class="mh-rule mt-auto" />

            <div class="isolate flex -space-x-2">
                <template
                    v-for="user in campaign.users"
                    :key="user.id"
                >
                    <Link
                        v-if="user.membership.hunter_id"
                        :href="route('campaigns.hunters.show', [campaign, user.membership.hunter_id])"
                        class="hover:z-50"
                    >
                        <img
                            :src="user.profile_photo_url"
                            :alt="user.name"
                            class="relative inline-block h-8 w-8 rounded-full ring-2 ring-gray-100 hover:ring-gray-300 dark:ring-gray-800 dark:hover:ring-gray-600"
                        >
                    </Link>
                    <img
                        v-else
                        :src="user.profile_photo_url"
                        :alt="user.name"
                        class="relative inline-block h-8 w-8 rounded-full ring-2 ring-gray-100 dark:ring-gray-800"
                    >
                </template>
            </div>
        </Card>
    </div>
</template>
