<script setup>
defineProps({
    loading: Boolean,
});
</script>

<template>
    <div class="relative">
        <div
            class="transition-opacity duration-150"
            :class="{ 'pointer-events-none opacity-40': loading }"
        >
            <slot />
        </div>

        <div
            v-if="loading"
            class="absolute inset-0 flex justify-center pt-16"
        >
            <svg
                class="h-8 w-8 animate-spin text-primary-500"
                viewBox="0 0 24 24"
                fill="none"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                />
                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4z"
                />
            </svg>
        </div>
    </div>
</template>
