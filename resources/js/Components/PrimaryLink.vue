<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { primaryButtonClass } from '@/Components/primaryButtonClass';

defineProps<{
    href: string;
}>();
</script>

<template>
    <Link
        :href="href"
        :class="primaryButtonClass"
    >
        <slot />
    </Link>
</template>
