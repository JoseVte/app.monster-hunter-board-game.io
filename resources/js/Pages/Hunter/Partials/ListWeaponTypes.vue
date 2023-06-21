<script setup>
import _ from "lodash";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    canEdit: Boolean,
    campaign: Object,
    hunter: Object,
    weaponTypes: [Array, Object],
});

const countWeaponCrafted = (weaponType)  => {
    return _.countBy(props.hunter.weapons, (weapon) => weapon.type_id === weaponType.id).true ?? 0;
};

const openWeaponType = (weaponType) => {
    const newUrl = route('campaigns.hunters.weapon-type.index', [props.campaign, props.hunter, weaponType]);
    router.visit(newUrl);
}

const clases = [
    'theme-slate',
    'theme-gray',
    'theme-zinc',
    'theme-neutral',
    'theme-stone',
    'theme-red',
    'theme-orange',
    'theme-amber',
    'theme-yellow',
    'theme-lime',
    'theme-green',
    'theme-emerald',
    'theme-teal',
    'theme-cyan',
    'theme-sky',
    'theme-blue',
    'theme-indigo',
    'theme-violet',
    'theme-purple',
    'theme-fuchsia',
    'theme-pink',
    'theme-rose',
];
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6 px-4 sm:px-0">
        <button
            v-for="weaponType in weaponTypes"
            :key="weaponType.id"
            class="flex rounded-md shadow-sm group"
            type="button"
            @click="openWeaponType(weaponType)"
        >
            <div
                class="flex w-16 h-full flex-shrink-0 items-center justify-center rounded-l-md text-sm text-white uppercase"
                :class="_.sample(clases)"
            >
                <div class="w-full h-full rounded-l-md flex items-center justify-center mh-icon">
                    <img
                        class="w-10 h-10 m-auto"
                        :src="weaponType.image_url"
                        :alt="weaponType.name"
                    >
                </div>
            </div>
            <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="flex-1 truncate px-4 py-2 text-sm">
                    <div
                        class="text-left font-medium text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-400"
                        v-text="weaponType.name"
                    />
                    <p class="text-left text-gray-500">
                        {{ countWeaponCrafted(weaponType) }} {{ $t('crafted.') }}
                    </p>
                </div>
            </div>
        </button>
    </div>
</template>

<style scoped lang="scss">
$themes: slate, gray, zinc, neutral, stone, red, orange, amber, yellow, lime, green, emerald, teal, cyan, sky, blue, indigo, violet, purple, fuchsia, pink, rose;
@each $theme in $themes {
    .theme-#{$theme} {
        @apply bg-#{$theme}-500;
        .mh-icon {
            @apply bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] to-#{$theme}-500 from-#{$theme}-100 group-hover:to-#{$theme}-300 dark:from-#{$theme}-900 dark:group-hover:to-#{$theme}-700 transition-all;
        }
    }
}
</style>
