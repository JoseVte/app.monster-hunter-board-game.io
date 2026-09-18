<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import fire from '~/types/fire.png';
import water from '~/types/water.png';
import ice from '~/types/ice.png';
import thunder from '~/types/thunder.png';
import dragon from '~/types/dragon.png';
import paralysis from '~/icons/paralysis.png';
import poison from '~/icons/poison.webp';
import sleep from '~/icons/sleep.svg';
import nitro from '~/icons/nitro.png';
import stun from '~/icons/stun.webp';

const props = defineProps({
    monster: Object,
});

const { t } = useI18n();

const ELEMENTS = [
    { key: 'fire', src: fire, alt: t('Fire') },
    { key: 'water', src: water, alt: t('Water') },
    { key: 'thunder', src: thunder, alt: t('Thunder') },
    { key: 'ice', src: ice, alt: t('Ice') },
    { key: 'dragon', src: dragon, alt: t('Dragon') },
];

const STATUSES = [
    { key: 'paralysis', src: paralysis, alt: t('Paralysis') },
    { key: 'poison', src: poison, alt: t('Poison') },
    { key: 'sleep', src: sleep, alt: t('Sleep') },
    { key: 'nitro', src: nitro, alt: t('Nitro') },
    { key: 'stun', src: stun, alt: t('Stun') },
];

const withValues = (resistances) => resistances.map((resistance) => ({
    ...resistance,
    value: props.monster[`resistance_${resistance.key}`],
}));

// The physical card prints elements and statuses as two separate blocks
// rather than one strip of ten.
const groups = computed(() => [
    { label: t('Elements'), rows: withValues(ELEMENTS) },
    { label: t('Status'), rows: withValues(STATUSES) },
]);
</script>

<template>
    <div class="flex flex-col gap-3">
        <div
            v-for="group in groups"
            :key="group.label"
        >
            <h4 class="mb-1 text-[0.65rem] font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                {{ group.label }}
            </h4>
            <div class="grid grid-cols-5 gap-3">
                <div
                    v-for="row in group.rows"
                    :key="row.key"
                    class="flex flex-col items-center gap-1"
                    :title="row.alt"
                >
                    <img
                        :src="row.src"
                        :alt="row.alt"
                        class="h-5 w-5"
                    >
                    <span
                        v-if="row.value === null"
                        class="text-gray-400 dark:text-gray-600"
                    >✗</span>
                    <span
                        v-else
                        class="flex gap-0.5 text-primary-500"
                    >
                        <span
                            v-for="n in row.value"
                            :key="n"
                        >★</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
