<script setup>
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";

// A set bonus needs all three pieces of its monster. Which three, and which of
// them are on, is the whole question, so the slots are drawn: lit for a piece
// worn, hollow for one still missing.
const props = defineProps({
    skill: Object,
    slotById: Object,
    equippedIds: Array,
})

const ICONS = { head: HelmetIcon, body: ArmorsIcon, leg: LegArmor };
const ORDER = ['head', 'body', 'leg'];

const pieces = () => (props.skill.bonus_set_armor ?? [])
    .map((id) => ({ id, slot: props.slotById[id] }))
    .filter(({ slot }) => slot)
    .sort((a, b) => ORDER.indexOf(a.slot) - ORDER.indexOf(b.slot))
    .map((piece) => ({ ...piece, icon: ICONS[piece.slot], worn: props.equippedIds.includes(piece.id) }));
</script>

<template>
    <span class="inline-flex items-center gap-1">
        <component
            :is="piece.icon"
            v-for="piece in pieces()"
            :key="piece.id"
            class="h-4 w-4"
            :class="piece.worn ? 'text-primary-500' : 'text-gray-400 dark:text-gray-600'"
        />
    </span>
</template>
