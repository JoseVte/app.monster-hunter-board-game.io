<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
    label: {
        type: String,
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <label class="cursor-pointer flex items-center">
        <input
            v-model="proxyChecked"
            type="checkbox"
            :value="value"
            class="sr-only"
        >
        <span class="switch" />
        <span class="ml-5 dark:text-gray-300">{{ label }}</span>
    </label>
</template>

<style scoped>
.switch {
    --switch-container-width: 50px;
    --switch-size: calc(var(--switch-container-width) / 2);

    height: var(--switch-size);
    flex-basis: var(--switch-container-width);
    border-radius: var(--switch-size);

    transition: all 0.25s ease-in-out;

    @apply w-20 flex items-center relative bg-gray-300 dark:bg-gray-700;
    @apply before:content-[''] before:absolute before:left-[1px] before:bg-white before:rounded-full;
}
.switch::before {
    height: calc(var(--switch-size) - 4px);
    width: calc(var(--switch-size) - 4px);
    transition: all 0.25s ease-in-out;
    @apply border-solid border-[2px] border-gray-300 dark:border-gray-700
}
input:checked + .switch {
    @apply bg-teal-400 dark:bg-teal-600;
    @apply before:border-teal-400 dark:before:border-teal-600;
}

input:checked + .switch:before {
    transform: translateX(
        calc(var(--switch-container-width) - var(--switch-size))
    );
}
</style>
