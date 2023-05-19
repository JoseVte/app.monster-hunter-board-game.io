<script setup>

</script>

<template>
    <div class="flex flex-col gap-4">
        <table class="bg-gray-50 dark:bg-gray-800 sm:rounded w-full overflow-hidden sm:shadow">
            <thead class="overflow-auto sm:rounded-t">
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 uppercase text-sm leading-normal overflow-auto sm:rounded-t">
                    <slot name="header" />
                </tr>
            </thead>
            <tbody class="text-gray-800 dark:text-gray-200 text-sm font-light">
                <slot />
            </tbody>
            <tfoot>
                <slot name="footer" />
            </tfoot>
        </table>

        <slot name="pagination" />
    </div>
</template>
