<script setup>
import ArmorTotalsRow from '@/Pages/Hunter/Partials/ArmorTotalsRow.vue';

defineProps({
    armors: {
        type: [Array, Object],
        default: () => [],
    },
});
</script>

<template>
    <div class="mh-frame bg-white/60 p-4 dark:bg-gray-900/40">
        <h3 class="mh-heading text-sm">
            {{ $t('Total Defense') }}
        </h3>

        <ArmorTotalsRow
            class="mt-3"
            :armors="armors"
        />
    </div>
</template>
