<script setup>
import { computed } from 'vue';
import WeaponsIcon from '@/Components/Icons/WeaponsIcon.vue';

const props = defineProps({
    weaponType: Object,
});

// The recolorable variant: currentColor fills instead of the fixed grays the
// seeder ships, so a rarity's text-* class tints the icon like WeaponsIcon
// already does. Raw, not a Vue component, so it can be injected with v-html.
const monoIcons = import.meta.glob('../../images/weapon-types/mono/*.svg', {
    query: '?raw',
    import: 'default',
    eager: true,
});

const markup = computed(() => {
    const slug = props.weaponType?.image_url?.split('/').pop()?.replace(/\.svg$/, '');
    const entry = Object.entries(monoIcons).find(([path]) => path.endsWith(`/${slug}.svg`));

    return entry?.[1] ?? null;
});
</script>

<template>
    <div
        v-if="markup"
        class="[&_svg]:h-full [&_svg]:w-full"
        v-html="markup"
    />
    <WeaponsIcon v-else />
</template>
