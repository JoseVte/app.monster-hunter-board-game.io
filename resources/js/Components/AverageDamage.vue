<script setup>
import {computed} from "vue";
import {averageDamage} from "@/damage";

// What one card off the top is worth. It rides beside the weapon's name rather
// than at the end of the damage spread, because it is the number a reader
// compares two weapons by and the spread is the detail behind it.
const props = defineProps({
    weapon: {
        type: Object,
        required: true,
    },
    size: {
        type: String,
        default: 'md',
        validator: (size) => ['sm', 'md'].includes(size),
    },
});

const average = computed(() => averageDamage(props.weapon));
</script>

<template>
    <span
        v-if="average"
        class="mh-value shrink-0 border-attack-line/60 text-attack-line"
        :class="size === 'sm' ? 'px-1.5 text-xs' : ''"
        :title="$t('Average damage')"
        :aria-label="$t('Average damage')"
    >&#8960;&nbsp;{{ average }}</span>
</template>
