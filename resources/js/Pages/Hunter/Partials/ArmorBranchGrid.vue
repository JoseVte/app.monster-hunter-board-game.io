<script setup>
import ArmorCard from "@/Pages/Hunter/Partials/ArmorCard.vue";
import ArmorSlot from "@/Pages/Hunter/Partials/ArmorSlot.vue";

// The three slots in a row per monster, so a set reads across in one line and
// the piece a hunter is missing is the gap in it. A phone gets the stacked
// lists instead: three columns and a rotated label do not fit across 390px.
const props = defineProps({
    canEdit: Boolean,
    showAllArmors: Boolean,
    showAdvanceSkillDescription: Boolean,
    campaign: Object,
    hunter: Object,
    armorSlots: Array,
    armors: [Array, Object],
    equipped: Object,
    slotById: Object,
    equippedIds: Array,
})

const owns = (armor) => armor && props.hunter.armors.some((held) => held.id === armor.id);

// With the switch off only what the hunter owns is drawn, so a monster they
// have nothing from would leave an empty row rather than a shorter list.
const branches = () => Object.entries(props.armors)
    .filter(([, pieces]) => props.showAllArmors || Object.values(pieces).some(owns));
</script>

<template>
    <div
        class="grid items-stretch gap-x-4 gap-y-3"
        style="grid-template-columns: 2.25rem repeat(3, minmax(0, 1fr))"
    >
        <div class="col-start-1" />
        <div
            v-for="slot in armorSlots"
            :key="slot.key"
            class="flex items-center gap-3"
        >
            <span class="flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-800">
                <component
                    :is="slot.icon"
                    class="h-5 w-5"
                    :class="equipped[slot.key] ? getRarityColor(equipped[slot.key].rarity) : 'text-gray-500'"
                />
            </span>
            <h3 class="mh-heading flex-1 text-sm">
                {{ slot.label }}
            </h3>
        </div>

        <div class="mh-branch-label col-start-1">
            <span>{{ $t('Current') }}</span>
        </div>
        <ArmorSlot
            v-for="slot in armorSlots"
            :key="`current-${slot.key}`"
            :show-advance-skill-description="showAdvanceSkillDescription"
            :armor="equipped[slot.key]"
            :slot-by-id="slotById"
            :equipped-ids="equippedIds"
        />

        <h4 class="mh-heading col-span-full mt-2 text-xs tracking-widest uppercase">
            {{ $t('Available') }}
        </h4>

        <template
            v-for="[branch, pieces] in branches()"
            :key="branch"
        >
            <div class="mh-branch-label col-start-1">
                <span>{{ branch }}</span>
            </div>
            <template
                v-for="slot in armorSlots"
                :key="`${branch}-${slot.key}`"
            >
                <ArmorCard
                    v-if="pieces[slot.key] && (showAllArmors || owns(pieces[slot.key]))"
                    :can-edit="canEdit"
                    :show-advance-skill-description="showAdvanceSkillDescription"
                    :campaign="campaign"
                    :hunter="hunter"
                    :icon="slot.icon"
                    :armor="pieces[slot.key]"
                />
                <div v-else />
            </template>
        </template>
    </div>
</template>
