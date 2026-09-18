<script setup>
// The card the components are printed on: a marked frame, an edge that lights
// when the thing is owned and a filled one when it is in hand. Weapons, armours,
// campaigns, days and achievements are all this.
defineProps({
    owned: Boolean,
    equipped: Boolean,
    clickable: Boolean,
});
</script>

<template>
    <div
        class="mh-card"
        :class="[
            clickable ? 'cursor-pointer' : 'cursor-default',
            { 'mh-card-owned': owned },
            { 'mh-card-equipped': equipped },
        ]"
    >
        <slot />
    </div>
</template>
