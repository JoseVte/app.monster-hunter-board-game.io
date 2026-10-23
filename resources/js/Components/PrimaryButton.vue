<script setup>
import { primaryButtonClass } from '@/Components/primaryButtonClass';

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        :class="primaryButtonClass"
    >
        <slot />
    </button>
</template>
