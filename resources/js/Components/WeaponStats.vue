<script setup>
import {computed} from "vue";
import StatBadge from "@/Components/StatBadge.vue";
import {attackBreakdown} from "@/damage";
import {iconFor} from "@/icons";
import deviationNone from '~/icons/deviation-none-icon.png';
import deviationLow from '~/icons/deviation-low-icon.png';
import deviationAverage from '~/icons/deviation-average-icon.png';
import deviationHigh from '~/icons/deviation-high-icon.png';

// Only the two bowguns deviate, and the rating is told apart by colour rather
// than by a number, so this badge carries no value the way the others do.
const deviations = {
    NONE: deviationNone,
    LOW: deviationLow,
    AVERAGE: deviationAverage,
    HIGH: deviationHigh,
};

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

const breakdown = computed(() => attackBreakdown(props.weapon));
const deviation = computed(() => deviations[props.weapon.deviation_key] ?? null);

// What the hit does besides damage: the one element the weapon carries and the
// statuses it can inflict. Both are plain names in the data, and every one of
// them already has artwork under `<name>_icon`.
const element = computed(() => iconFor(`${props.weapon.element}_icon`));
const statuses = computed(() => (props.weapon.status_attacks ?? [])
    .map((status) => iconFor(`${status}_icon`))
    .filter(Boolean));
</script>

<template>
    <!-- A wiki card has the width for one line, and reads better as one: what
         it protects with, what it hits for, and what the hit carries. A tree
         card does not, so there the effects sit above the damage and the block
         is only as wide as that row, which is what centres it on the card.
         `contents` is what lets one set of markup do both: at the wider size
         the two groups dissolve into the outer row and `order` decides where
         the damage lands among them. -->
    <div
        v-if="breakdown.length || weapon.defense || deviation || element || statuses.length"
        class="flex w-fit"
        :class="size === 'sm'
            ? 'mx-auto flex-col items-center gap-1'
            : 'flex-wrap items-center gap-x-4 gap-y-2'"
    >
        <div
            v-if="weapon.defense || deviation || element || statuses.length"
            :class="size === 'sm'
                ? 'flex flex-wrap items-center justify-center gap-1.5'
                : 'contents'"
        >
            <!-- Most weapons add no defense at all, and a zero is not a value
                 the card prints. -->
            <StatBadge
                v-if="weapon.defense"
                variant="defense"
                :value="weapon.defense"
                :size="size"
                class="order-1"
            />
            <img
                v-if="element"
                :src="element.src"
                :alt="element.alt"
                :title="element.alt"
                class="order-3 w-auto shrink-0"
                :class="size === 'sm' ? 'h-6' : 'h-8'"
            >
            <img
                v-for="status in statuses"
                :key="status.alt"
                :src="status.src"
                :alt="status.alt"
                :title="status.alt"
                class="order-4 w-auto shrink-0"
                :class="size === 'sm' ? 'h-6' : 'h-8'"
            >
            <img
                v-if="deviation"
                :src="deviation"
                :alt="`${$t('Deviation')}: ${weapon.deviation}`"
                :title="`${$t('Deviation')}: ${weapon.deviation}`"
                class="order-5 w-auto shrink-0"
                :class="size === 'sm' ? 'h-6' : 'h-8'"
            >
        </div>

        <div
            v-if="breakdown.length"
            :class="size === 'sm'
                ? 'flex flex-wrap items-center justify-center gap-x-1.5 gap-y-1'
                : 'contents'"
        >
            <StatBadge
                v-for="attack in breakdown"
                :key="attack.value"
                :value="attack.value"
                :count="attack.count"
                :size="size"
                class="order-2"
            />
        </div>
    </div>
</template>
