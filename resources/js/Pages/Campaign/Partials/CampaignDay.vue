<script setup>
import Calendar from "@/Components/Icons/Calendar.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
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
        <div
            class="py-4 px-4 h-full w-full text-gray-900 dark:text-white bg-gray-200 dark:bg-gray-700"
        >
            <div class="flex items-center gap-4">
                <span>#{{ day.number }}</span>
                <template v-if="day.monster_id">
                    <MonstersIcon class="h-4 min-h-4 w-4 min-w-4" />
                </template>
                <template v-else>
                    <Calendar class="h-4 min-h-4 w-4 min-w-4" />
                </template>
            </div>
            <div
                v-if="day.monster_id"
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
        </div>
    </component>
</template>

<style scoped>

</style>
