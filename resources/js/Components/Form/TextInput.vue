<script setup lang="ts">
import { computed, onMounted, ref, useAttrs } from 'vue';

defineProps<{
    modelValue: string | number;
}>();

defineEmits(['update:modelValue']);

// Several callers hold a template ref to this component and call `.focus()`
// on it directly (e.g. `passwordInput.value.focus()` in
// `Profile/Partials/SetPasswordForm.vue`), so the exposed shape below stays
// one method taking no arguments, unchanged from the runtime version;
// widening it would break them. The `?.` here is only about `input.value`
// possibly being null before the element mounts; it does not change what is
// exposed.
const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });

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
        <input
            v-bind="controlAttrs"
            ref="input"
            class="mh-field block w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:outline-hidden"
            :value="modelValue"
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        >
    </span>
</template>
