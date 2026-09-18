<script setup>
defineProps({
    form: Object,
    decrement: Function,
    increment: Function,
    value: Number,
    max: {
        type: [Number, String],
        default: null,
    },
})
</script>

<template>
    <div class="mh-notch flex h-10 flex-row bg-transparent [--mh-notch-color:var(--color-gray-500)] dark:[--mh-notch-color:var(--color-gray-500)]">
        <button
            type="button"
            class="border border-gray-400 bg-white/70 text-gray-700 hover:bg-gray-200 hover:text-gray-900 dark:border-gray-600 dark:bg-gray-950/60 dark:text-parchment dark:hover:bg-gray-800 dark:hover:text-white flex items-center justify-center h-full w-10 rounded-l cursor-pointer outline-hidden"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="decrement"
        >
            <svg
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18 12H6"
                />
            </svg>
        </button>
        <div
            class="flex w-auto items-center border-y border-gray-400 bg-white/70 px-2 text-center text-md font-semibold text-gray-800 outline-hidden dark:border-gray-600 dark:bg-gray-950/60 dark:text-parchment"
            :class="{ 'opacity-25': form.processing }"
        >
            {{ value }}<span v-if="max">&nbsp;/&nbsp;{{ max }}</span>
        </div>
        <button
            type="button"
            class="border border-gray-400 bg-white/70 text-gray-700 hover:bg-gray-200 hover:text-gray-900 dark:border-gray-600 dark:bg-gray-950/60 dark:text-parchment dark:hover:bg-gray-800 dark:hover:text-white flex items-center justify-center h-full w-10 rounded-r cursor-pointer outline-hidden"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="increment"
        >
            <svg
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 6v12m6-6H6"
                />
            </svg>
        </button>
    </div>
</template>

<style scoped>

</style>
