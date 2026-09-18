<script setup>
import { computed, onMounted, ref, useAttrs } from 'vue';

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

// The wrapper is the root now, so every attribute the caller passes would land
// on it instead of the control: id, type, placeholder, required. Chrome even
// styled the span as a field, because @tailwindcss/forms matches [type=email].
// Layout classes stay on the wrapper, everything else goes to the control.
defineOptions({ inheritAttrs: false });

const attrs = useAttrs();
const controlAttrs = computed(() => Object.fromEntries(
    Object.entries(attrs).filter(([name]) => name !== 'class' && name !== 'style'),
));
</script>

<template>
    <!-- An input carries no pseudo elements, so it cannot take the corner
         marks itself. The wrapper draws them over its corners, holding the
         border colour without a border of its own. -->
    <span
        class="mh-notch relative block [--mh-notch-color:var(--color-gray-400)] focus-within:[--mh-notch-color:var(--color-primary-800)] dark:[--mh-notch-color:var(--color-gray-600)] dark:focus-within:[--mh-notch-color:var(--color-primary-200)]"
        :class="attrs.class"
        :style="attrs.style"
    >
        <select
            v-bind="controlAttrs"
            ref="input"
            class="mh-field block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:outline-hidden"
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
    </span>
</template>
