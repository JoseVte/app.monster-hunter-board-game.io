<script setup>
import _ from "lodash";
import {computed} from "vue";
import Card from "@/Components/Card.vue";
import Calendar from "@/Components/Icons/Calendar.vue";
import UpdateCampaignDayModal from "@/Pages/Campaign/Partials/UpdateCampaignDayModal.vue";

const props = defineProps({
    campaign: Object,
    day: Object,
    days: [Array, Object],
    monsters: [Array, Object],
    // Passed straight through to the edit modal, which is the only thing that
    // needs it; `CampaignDay` itself only reads a day back.
    maxActivities: Number,
    canEdit: Boolean
})

// A hunter holds one pivot row per activity, so `day.hunters` repeats a hunter
// who did more than one. Grouped back into one line per hunter: listing the
// raw rows would print the name three times, and the `:key` would be a
// duplicate.
const hunterActivities = computed(() => _.map(
    _.groupBy(props.day.hunters, 'id'),
    (rows) => ({
        id: rows[0].id,
        name: rows[0].name,
        activities: rows.map((row) => row.pivot.downtime_activity).filter(Boolean),
    })
))
</script>

<template>
    <component
        :is="canEdit ? UpdateCampaignDayModal : 'div' "
        :campaign="campaign"
        :days="days"
        :monsters="monsters"
        :max-activities="maxActivities"
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
                    v-for="hunter in hunterActivities"
                    :key="hunter.id"
                    class="flex gap-2 items-start"
                >
                    <span class="text-gray-600 dark:text-gray-400">{{ hunter.name }}</span>
                    <span v-if="! hunter.activities.length">-</span>
                    <span
                        v-else
                        class="flex flex-col"
                    >
                        <span
                            v-for="activity in hunter.activities"
                            :key="activity.id"
                        >{{ activity.name }}</span>
                    </span>
                </div>
            </div>
        </Card>
    </component>
</template>

<style scoped>

</style>
