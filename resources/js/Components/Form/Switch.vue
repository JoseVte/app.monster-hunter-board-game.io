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
        <span class="ml-3 wrap-break-word dark:text-gray-300">{{ label }}</span>
    </label>
</template>

<style scoped>
@reference "../../../css/app.css";

/* The knob is sized in plain pixels rather than derived from the track through
   a second custom property. The derived one resolved to nothing inside the
   pseudo element and the knob came out zero by zero, which is to say invisible. */
.switch {
    height: 24px;
    width: 48px;
    flex: none;
    border-radius: 9999px;
    transition: background-color 0.25s ease-in-out;

    @apply relative flex items-center bg-gray-300 dark:bg-gray-700;
}

.switch::before {
    content: '';
    height: 18px;
    width: 18px;
    top: 3px;
    left: 3px;
    transition: transform 0.25s ease-in-out;

    @apply absolute rounded-full bg-white shadow-sm;
}

input:checked + .switch {
    /* The accent the borders, the equipped card and the focus rings already use,
       so a switch reads as part of the set. */
    @apply bg-primary-500;
}

input:checked + .switch::before {
    transform: translateX(24px);
}
</style>
