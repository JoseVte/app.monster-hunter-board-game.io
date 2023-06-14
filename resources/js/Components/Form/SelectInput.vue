<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    options: [Array, Object],
    placeholder: String
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        ref="input"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option
            v-if="placeholder"
            disabled
            value=""
            v-html="placeholder"
        />
        <option
            v-for="(label, value) in options"
            :key="value"
            :value="value"
            v-html="label"
        />
    </select>
</template>
