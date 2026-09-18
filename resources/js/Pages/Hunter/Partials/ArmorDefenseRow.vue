<script setup>
import Resistance from "@/Components/Icons/Resistance.vue";
import defenseIcon from '~/icons/defense-icon.png';

// One piece's numbers. Shared by the card and by the panel showing what is worn.
const props = defineProps({
    armor: Object,
})

const ELEMENTS = ['fire', 'water', 'thunder', 'ice', 'dragon'];

// Only the elements this piece protects against. The row that adds them all up
// sits at the top of the tab; five empty pentagons here would say nothing.
const resistances = () => ELEMENTS
    .map((element) => ({ element, value: props.armor[`defense_${element}`] }))
    .filter(({ value }) => value);
</script>

<template>
    <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
        <span class="flex items-center gap-1.5">
            <img
                :src="defenseIcon"
                :alt="$t('Defense')"
                :title="$t('Defense')"
                class="h-5 w-5"
            >
            <span class="mh-value">{{ armor.defense }}</span>
        </span>
        <span
            v-for="resistance in resistances()"
            :key="resistance.element"
            class="flex items-center gap-1.5"
        >
            <Resistance :element="resistance.element" />
            <span class="mh-value">{{ resistance.value }}</span>
        </span>
    </div>
</template>
