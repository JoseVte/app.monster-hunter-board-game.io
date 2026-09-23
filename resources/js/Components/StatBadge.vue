<script setup>
import {computed} from "vue";
import damageValue from '~/icons/damage-value-icon.png';
import defenseIcon from '~/icons/defense-icon.png';

// A game symbol carrying a number: the damage a card is worth, or the defense a
// weapon adds. Drawn without the number, one symbol repeated three times only
// ever said "damage" three times.
const props = defineProps({
    variant: {
        type: String,
        default: 'damage',
        validator: (variant) => ['damage', 'defense'].includes(variant),
    },
    value: {
        type: Number,
        required: true,
    },
    // How many cards of that damage the weapon brings. Defense has no count.
    count: {
        type: Number,
        default: null,
    },
    // A tree card has room for the number alone, a detail page for `×n`.
    size: {
        type: String,
        default: 'md',
        validator: (size) => ['sm', 'md'].includes(size),
    },
});

const source = computed(() => (props.variant === 'defense' ? defenseIcon : damageValue));
</script>

<template>
    <span
        class="flex items-center"
        :class="size === 'sm' ? 'gap-0.5' : 'gap-1.5'"
    >
        <span
            class="relative inline-flex shrink-0"
            :class="size === 'sm' ? 'h-6 w-6' : 'h-8 w-8'"
        >
            <img
                :src="source"
                :alt="variant === 'defense' ? $t('Defense') : $t('Damage')"
                class="h-full w-full"
            >
            <!-- Both symbols are a flat shape around their own centre, the star
                 filled rather than cut out, so the number sits in the middle of
                 the image. -->
            <span
                class="mh-stat-number absolute inset-0 flex items-center justify-center font-bold leading-none tabular-nums"
                :class="size === 'sm' ? 'text-[0.7rem]' : 'text-sm'"
            >{{ value }}</span>
        </span>
        <span
            v-if="count !== null"
            :class="size === 'sm'
                ? 'text-xs font-semibold tabular-nums text-gray-700 dark:text-parchment-dim'
                : 'mh-value'"
        >{{ size === 'sm' ? count : `×${count}` }}</span>
    </span>
</template>

<style>
/* White with a black edge rather than a dark fill: the same number has to read
   on the orange star and on the cream shield, and no single flat colour does
   both. The eight shadows are the outline; `-webkit-text-stroke` centres itself
   on the glyph edge instead, which eats a digit this small from the inside. */
.mh-stat-number {
    color: #fff;
    text-shadow:
        0 1px 0 #000, 1px 0 0 #000, 0 -1px 0 #000, -1px 0 0 #000,
        1px 1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, -1px -1px 0 #000;
}
</style>
