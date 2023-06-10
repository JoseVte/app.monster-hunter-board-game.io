<script setup>
defineProps({
    form: Object,
    decrement: Function,
    increment: Function,
    value: Number,
    max: {
        type: Number,
        default: null,
    },
})
</script>

<template>
    <div class="flex flex-row h-10 rounded-lg relative bg-transparent">
        <button
            type="button"
            class="bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 flex items-center justify-center h-full w-10 rounded-l cursor-pointer outline-none"
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
            class="outline-none px-2 w-auto border-0 focus:outline-none text-center bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 font-semibold text-md flex items-center"
            :class="{ 'opacity-25': form.processing }"
        >
            {{ value }}<span v-if="max">&nbsp;/&nbsp;{{ max }}</span>
        </div>
        <button
            type="button"
            class="bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 flex items-center justify-center h-full w-10 rounded-r cursor-pointer outline-none"
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
