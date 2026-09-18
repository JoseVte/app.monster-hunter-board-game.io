<script setup>

</script>

<template>
    <!-- The notched corners every other box on the wiki carries, rather than
         rounding: the two are alternatives, not a pair, so rounding and the
         overflow clip it needed are both gone with it.

         mh-notch rather than mh-frame: mh-frame's marks sit a pixel outside
         the border, which is fine on a plain panel but here the top corners
         land on the header row. mh-notch draws them flush with the inside of
         the border instead, in the accent colour rather than border-inherit,
         so they still read against the header's own background. -->
    <div class="flex flex-col gap-4">
        <table class="mh-notch w-full border border-gray-300 bg-gray-50 [--mh-notch-color:var(--color-primary-500)] sm:shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:[--mh-notch-color:var(--color-primary-400)]">
            <thead class="overflow-auto">
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 uppercase text-sm leading-normal overflow-auto">
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
