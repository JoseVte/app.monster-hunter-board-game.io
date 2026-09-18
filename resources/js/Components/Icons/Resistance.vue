<script setup>
import { computed } from 'vue';
import { PENTAGON, resistances } from '@/icons';

// The same pentagon replaceIcons builds for the `:fire_resistance_icon:` tokens
// in the seed text, as a component, so armour can draw one without going through
// a string of markup. Both read the geometry and the colours from icons.js.
const props = defineProps({
    element: {
        type: String,
        required: true,
        validator: (element) => `${element}_resistance_icon` in resistances,
    },
});

const resistance = computed(() => resistances[`${props.element}_resistance_icon`]);
</script>

<template>
    <span
        class="mh-resistance relative inline-flex h-5 w-5 shrink-0 items-center justify-center align-text-bottom"
        :class="`mh-resistance-${element}`"
        :title="resistance.alt"
    >
        <svg
            viewBox="0 0 20 20"
            class="absolute inset-0 h-full w-full"
            aria-hidden="true"
        >
            <polygon :points="PENTAGON" />
        </svg>
        <img
            :src="resistance.src"
            :alt="resistance.alt"
            class="relative h-3 w-3"
        >
    </span>
</template>
