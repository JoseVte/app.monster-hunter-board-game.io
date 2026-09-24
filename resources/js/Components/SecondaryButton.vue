<script setup lang="ts">
// The button's own default matters here: the element is a native `<button>`,
// and omitting the `type` attribute makes a browser default it to `submit`,
// not `button`. Dropping this default (as the optional-with-no-default
// pattern used elsewhere in this task does for props that only ever feed a
// template comparison) would be a real behaviour change here, since a
// SecondaryButton left inside a `<form>` would start submitting it.
withDefaults(defineProps<{
    type?: 'button' | 'submit' | 'reset';
}>(), {
    type: 'button',
});
</script>

<template>
    <button
        :type="type"
        class="mh-notch inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-xs hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-hidden focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
