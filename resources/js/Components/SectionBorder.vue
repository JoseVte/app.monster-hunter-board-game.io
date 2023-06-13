<template>
    <div
        v-if="$slots.default"
        class="dark:text-gray-300"
    >
        <div class="py-8">
            <div
                class="grid grid-template-section items-center before:content-[''] before:hidden sm:before:block before:h-[1px] before:bg-gray-200 dark:before:bg-gray-200"
            >
                <slot />
            </div>
        </div>
    </div>
    <div
        v-else
        class="hidden sm:block"
    >
        <div class="py-8">
            <div class="border-t border-gray-200 dark:border-gray-700" />
        </div>
    </div>
</template>
<style scoped>
.grid-template-section {
    grid-template-columns: 1fr max-content;
    grid-column-gap: 1.2rem;
}
</style>
