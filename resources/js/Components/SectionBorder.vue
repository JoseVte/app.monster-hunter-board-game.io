<template>
    <div
        v-if="$slots.default"
        class="dark:text-gray-300"
    >
        <div class="py-8">
            <div
                class="grid grid-template-section items-center before:content-[''] before:hidden sm:before:block before:h-px before:bg-gray-200 dark:before:bg-gray-700"
            >
                <slot />
            </div>
        </div>
    </div>
    <!-- This was hidden below sm, so on a phone the separator drew neither a rule
         nor the space around it and one section ran straight into the next. It is
         the only thing carrying the rhythm between them. -->
    <div v-else>
        <div class="py-6 sm:py-8">
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
