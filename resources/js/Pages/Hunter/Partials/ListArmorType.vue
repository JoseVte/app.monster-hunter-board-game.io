<script setup>
import ArmorCard from "@/Pages/Hunter/Partials/ArmorCard.vue";
import ArmorSlot from "@/Pages/Hunter/Partials/ArmorSlot.vue";

// One slot on a phone, where the row per monster does not fit. The monster is
// a heading above its piece instead of a label rotated down the left edge.
const props = defineProps({
    canEdit: Boolean,
    showAllArmors: Boolean,
    showAdvanceSkillDescription: Boolean,
    campaign: Object,
    hunter: Object,
    armorSlot: Object,
    armors: [Array, Object],
    equipped: Object,
    slotById: Object,
    equippedIds: Array,
})

const owns = (armor) => armor && props.hunter.armors.some((held) => held.id === armor.id);

const branches = () => Object.entries(props.armors)
    .map(([branch, pieces]) => ({ branch, armor: pieces[props.armorSlot.key] }))
    .filter(({ armor }) => armor && (props.showAllArmors || owns(armor)));
</script>

<template>
    <div class="flex flex-col gap-3">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-800">
                <component
                    :is="armorSlot.icon"
                    class="h-5 w-5"
                    :class="equipped ? getRarityColor(equipped.rarity) : 'text-gray-500'"
                />
            </span>
            <h3 class="mh-heading flex-1 text-sm">
                {{ armorSlot.label }}
            </h3>
        </div>

        <ArmorSlot
            :show-advance-skill-description="showAdvanceSkillDescription"
            :armor="equipped"
            :slot-by-id="slotById"
            :equipped-ids="equippedIds"
        />

        <h4 class="mh-heading text-xs tracking-widest uppercase">
            {{ $t('Available') }}
        </h4>

        <div
            v-for="entry in branches()"
            :key="entry.branch"
            class="flex flex-col gap-1"
        >
            <span class="text-xs tracking-widest text-gray-600 uppercase dark:text-gray-400">
                {{ entry.branch }}
            </span>
            <ArmorCard
                :can-edit="canEdit"
                :show-advance-skill-description="showAdvanceSkillDescription"
                :campaign="campaign"
                :hunter="hunter"
                :icon="armorSlot.icon"
                :armor="entry.armor"
            />
        </div>
    </div>
</template>
