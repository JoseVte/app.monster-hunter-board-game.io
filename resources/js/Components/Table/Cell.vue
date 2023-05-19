<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({url: String})
</script>

<template>
    <td
        class="text-left whitespace-nowrap select-none md:select-auto"
        :class="{'py-3 px-3 md:px-6': !url}"
    >
        <Link
            v-if="url"
            :href="url"
            class="py-3 px-3 md:px-6 block"
        >
            <slot />
        </Link>
        <slot v-else />
    </td>
</template>
