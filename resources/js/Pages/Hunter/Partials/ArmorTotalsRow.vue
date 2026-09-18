<script setup>
import { computed } from 'vue';
import Resistance from '@/Components/Icons/Resistance.vue';
import defenseIcon from '~/icons/defense.png';
import { DEFENSE_ELEMENTS, totalDefense } from '@/armorDefense';

// Defence and the five resistances, added up from what is worn. The tab's panel
// and the line in the sheet's header both show it, so it is drawn once.
const props = defineProps({
    armors: {
        type: [Array, Object],
        default: () => [],
    },
});

const defense = computed(() => totalDefense(props.armors));

// Every element keeps its place whether or not anything in hand grants it, so
// the row does not reshuffle as pieces are swapped and each one is always in
// the same spot to read.
const elements = computed(() => DEFENSE_ELEMENTS.map((element) => ({
    element,
    value: totalDefense(props.armors, `defense_${element}`),
})));
</script>

<template>
    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
        <span class="flex items-center gap-1.5">
            <img
                :src="defenseIcon"
                :alt="$t('Defense')"
                :title="$t('Defense')"
                class="h-5 w-5"
                :class="{ grayscale: !defense }"
            >
            <span
                class="mh-value"
                :class="{ 'mh-value-muted': !defense }"
            >{{ defense }}</span>
        </span>

        <span
            v-for="element in elements"
            :key="element.element"
            class="flex items-center gap-1.5"
        >
            <Resistance
                :element="element.element"
                :class="{ grayscale: !element.value }"
            />
            <span
                class="mh-value"
                :class="{ 'mh-value-muted': !element.value }"
            >{{ element.value }}</span>
        </span>
    </div>
</template>
