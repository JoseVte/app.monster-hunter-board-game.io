<script setup>
defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <span class="group relative inline-flex w-full">
        <slot />

        <span
            v-if="!disabled"
            class="mh-frame pointer-events-none absolute bottom-full left-1/2 z-20 mb-2 w-max max-w-xs -translate-x-1/2 bg-white px-3 py-2 text-xs text-gray-900 opacity-0 shadow-lg transition-opacity duration-150 group-hover:opacity-100 group-focus-within:opacity-100 dark:bg-gray-900 dark:text-parchment"
        >
            <slot name="content" />
        </span>
    </span>
</template>
