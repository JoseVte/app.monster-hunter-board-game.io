<script setup>
import Card from "@/Components/Card.vue";
import Calendar from "@/Components/Icons/Calendar.vue";
import UpdateCampaignDayModal from "@/Pages/Campaign/Partials/UpdateCampaignDayModal.vue";

defineProps({
    campaign: Object,
    day: Object,
    days: [Array, Object],
    monsters: [Array, Object],
    canEdit: Boolean
})
</script>

<template>
    <component
        :is="canEdit ? UpdateCampaignDayModal : 'div' "
        :campaign="campaign"
        :days="days"
        :monsters="monsters"
        :day="day"
    >
        <Card
            class="h-full w-full gap-2 p-4"
            :owned="!!day.monster_id"
            clickable
        >
            <div class="flex items-center gap-3">
                <span>#{{ day.number }}</span>
                <template v-if="day.monster_id">
                    <img
                        :src="day.monster.icon_url"
                        :alt="day.monster.name"
                        class="h-4 min-h-4 w-4 min-w-4 rounded-full object-contain"
                    >
                </template>
                <template v-else>
                    <Calendar class="h-4 min-h-4 w-4 min-w-4" />
                </template>
            </div>
            <div
                v-if="day.monster_id"
                class="mh-card-name text-base"
            >
                {{ day.monster.name }}
            </div>
            <div
                v-else
                class="flex flex-col gap-2"
            >
                <div
                    v-for="hunter in day.hunters"
                    :key="hunter.id"
                    class="flex gap-2 items-center"
                >
                    <span class="text-gray-600 dark:text-gray-400">{{ hunter.name }}</span>
                    {{ hunter.pivot.downtime_activity_id ? hunter.pivot.downtime_activity.name : '-' }}
                </div>
            </div>
        </Card>
    </component>
</template>

<style scoped>

</style>
