<script setup>
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    campaigns: Array
})
</script>

<template>
    <!-- Campaign Management -->
    <div class="block px-4 py-2 text-xs text-gray-400">
        {{ $t('Manage Campaigns') }}
    </div>

    <DropdownLink
        :href="route('campaigns.create')"
    >
        {{ $t('Create New Campaign') }}
    </DropdownLink>

    <!-- Campaign Switcher -->
    <template v-if="campaigns.length > 1">
        <div class="border-t border-gray-200 dark:border-gray-600" />

        <div class="block px-4 py-2 text-xs text-gray-400">
            {{ $t('Switch Campaigns') }}
        </div>

        <template
            v-for="campaign in campaigns"
            :key="campaign.id"
        >
            <DropdownLink :href="route('campaigns.show', campaign)">
                <div class="flex items-center">
                    <svg
                        v-if="campaign.id == $page.props.current_campaign_id"
                        class="mr-2 h-5 w-5 text-green-400"
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

                    <div>{{ campaign.name }}</div>
                </div>
            </DropdownLink>
        </template>
    </template>
</template>

<style scoped>

</style>
