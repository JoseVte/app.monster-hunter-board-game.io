<script setup>
import {Link} from "@inertiajs/vue3";
import _ from "lodash";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Check from "@/Components/Icons/Check.vue";

const props = defineProps({
    canEdit: Boolean,
    campaign: Object,
    hunter: Object,
    weaponType: Object,
    weapons: [Array, Object]
});

const getRarityColor = (rarity) => {
    switch (rarity) {
    case 1:
        return 'text-gray-600 dark:text-gray-500';
    case 2:
        return 'text-gray-400 dark:text-gray-300';
    case 3:
        return 'text-lime-600';
    case 4:
        return 'text-green-600';
    }
}

const hunterWeaponCount = (weapon) => {
    return _.filter(props.hunter.weapons, (hunterWeapon) => {
        return hunterWeapon.id === weapon.id;
    }).length;
}
</script>

<template>
    <div class="mt-6 px-4 sm:px-0">
        <Link
            :href="route('campaigns.hunters.show', [campaign, hunter, 'weapons'])"
            class="text-gray-800 dark:text-gray-200 text-sm flex items-center"
        >
            <svg
                class="h-5 w-5 mr-2"
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
                    d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"
                />
            </svg>
            {{ $t('Back to all weapon types') }}
        </Link>

        <table class="mt-4 hidden md:table">
            <tr
                v-for="(weaponBranch, branch) in weapons"
                :key="branch"
            >
                <td class="align-middle pr-4 h-fit">
                    <div class="border capitalize h-fit lg:min-w-[140px] rounded border-gray-400 dark:border-gray-500 bg-gray-300 dark:bg-gray-600 p-2 text-gray-800 dark:text-gray-200">
                        {{ branch }}
                    </div>
                </td>
                <td class="align-middle h-full py-2 w-full">
                    <div class="grid grid-cols-4 gap-8 items-center h-full w-full">
                        <template
                            v-for="(weapon, subIndex) in weaponBranch"
                            :key="weapon.id"
                        >
                            <div
                                v-if="subIndex + 1 === weapon.rarity"
                                class="weapon-box relative border rounded border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 p-2 text-gray-800 dark:text-gray-200"
                            >
                                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-2">
                                    <div class="flex justify-between items-center w-full lg:w-auto">
                                        <div class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                                            <WeaponsIcon
                                                class="h-4 w-4"
                                                :class="getRarityColor(weapon.rarity)"
                                            />
                                        </div>
                                        <div
                                            v-if="weapon.is_default || hunterWeaponCount(weapon)"
                                            class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8 flex lg:hidden items-center justify-center"
                                        >
                                            <Check
                                                class="h-6 w-6 text-green-500"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex gap-2 items-center justify-between">
                                        {{ weapon.name }} <span v-if="!weapon.is_default && hunterWeaponCount(weapon)">({{ hunterWeaponCount(weapon) }})</span>
                                    </div>
                                    <div
                                        v-if="weapon.is_default || hunterWeaponCount(weapon)"
                                        class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8  hidden lg:flex items-center justify-center"
                                    >
                                        <Check
                                            class="h-6 w-6 text-green-500"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div
                                v-else
                                class="weapon-box-line relative border-b rounded border-gray-300 dark:border-gray-500 h-[1px]"
                            />
                        </template>
                    </div>
                </td>
            </tr>
        </table>

        <div
            v-for="(weaponBranch, branch) in weapons"
            :key="branch"
            class="mt-4 md:hidden"
        >
            <div class="border text-center mb-4 capitalize h-fit rounded border-gray-400 dark:border-gray-500 bg-gray-300 dark:bg-gray-600 p-2 text-gray-800 dark:text-gray-200">
                {{ branch }}
            </div>

            <div class="grid gap-8 items-center h-full w-full">
                <template
                    v-for="weapon in weaponBranch"
                    :key="weapon.id"
                >
                    <div
                        v-if="weapon.id"
                        class="weapon-box-vertical relative border rounded border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 p-2 text-gray-800 dark:text-gray-200"
                    >
                        <div class="grid grid-cols-3 gap-2 sm:w-full">
                            <div class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                                <WeaponsIcon
                                    class="h-4 w-4"
                                    :class="getRarityColor(weapon.rarity)"
                                />
                            </div>
                            <div class="flex gap-2 items-center justify-between">
                                {{ weapon.name }} <span v-if="!weapon.is_default && hunterWeaponCount(weapon)">({{ hunterWeaponCount(weapon) }})</span>
                            </div>
                            <div class="w-full text-right">
                                <div
                                    v-if="weapon.is_default || hunterWeaponCount(weapon)"
                                    class="bg-gray-300 dark:bg-gray-800 ml-auto rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center"
                                >
                                    <Check
                                        class="h-6 w-6 text-green-500"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.weapon-box:not(:first-child) {
    @apply before:content-[''] before:h-0 before:w-0 before:-left-2 before:top-1/2 before:absolute;
    @apply before:border-solid before:border-transparent before:border-l-gray-300 dark:before:border-l-gray-500 before:border-y-4 before:border-l-8 before:border-r-0 before:-translate-y-1/2;
}
.weapon-box:not(:last-child), .weapon-box-line {
    @apply after:content-[''] after:h-[1px] after:w-8 after:-right-8 after:top-1/2 after:absolute after:bg-gray-300 dark:after:bg-gray-500;
}

.weapon-box-vertical:not(:first-child) {
    @apply before:content-[''] before:h-0 before:w-0 before:-top-2 before:left-1/2 before:absolute;
    @apply before:border-solid before:border-transparent before:border-t-gray-300 dark:before:border-t-gray-500 before:border-x-4 before:border-t-8 before:border-b-0 before:-translate-x-1/2;
}
.weapon-box-vertical:not(:last-child) {
    @apply after:content-[''] after:h-8 after:w-[1px] after:-bottom-8 after:left-1/2 after:absolute after:bg-gray-300 dark:after:bg-gray-500;
}
</style>
