<script setup>
import _ from "lodash";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Wrench from "@/Components/Icons/Wrench.vue";
import Check from "@/Components/Icons/Check.vue";
import CogIcon from "@/Components/Icons/CogIcon.vue";
import KnightIcon from "@/Components/Icons/KnightIcon.vue";
import fire from '~/types/fire.png';
import water from '~/types/water.png';
import thunder from '~/types/thunder.png';
import ice from '~/types/ice.png';
import dragon from '~/types/dragon.png';


const props = defineProps({
    canEdit: Boolean,
    showAllArmors: Boolean,
    showAdvanceSkillDescription: Boolean,
    campaign: Object,
    hunter: Object,
    icon: [Object, String],
    armors: [Array, Object]
})

const hunterArmorCount = (armor) => {
    return _.filter(props.hunter.armors, (hunterArmor) => {
        return hunterArmor.id === armor.id;
    }).length;
}
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
        <div
            v-for="(headArmors, rarity) in armors"
            :key="rarity"
            class="flex items-center justify-start gap-2 flex-col"
        >
            <template
                v-for="armor in headArmors"
                :key="armor.id"
            >
                <div
                    v-if="showAllArmors || hunterArmorCount(armor)"
                    class="border w-full flex items-center gap-2 rounded border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 p-2 text-gray-800 dark:text-gray-200"
                >
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <component
                                    :is="icon"
                                    v-if="icon"
                                    class="h-6 w-6"
                                    :class="getRarityColor(armor.rarity)"
                                />
                                {{ armor.name }}
                            </div>
                            <div
                                v-if="hunterArmorCount(armor)"
                                class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center"
                            >
                                <Check
                                    class="h-6 w-6 text-green-500"
                                />
                            </div>
                        </div>
                        <div
                            class="border-t border-gray-500 pt-2 flex items-center justify-between"
                        >
                            {{ $t('Defense') }}: {{ armor.defense }}
                            <span
                                v-if="armor.defense_fire"
                                class="flex gap-1 items-center px-2 py-1 text-sm rounded-full text-red-700 dark:text-red-300 bg-red-300 dark:bg-red-700"
                            >
                                <img
                                    :src="fire"
                                    :alt="$t('Fire')"
                                    class="h-5 w-5"
                                >
                                {{ armor.defense_fire }}
                            </span>
                            <span
                                v-if="armor.defense_water"
                                class="flex gap-1 items-center px-2 py-1 text-sm rounded-full text-blue-700 dark:text-blue-300 bg-blue-300 dark:bg-blue-700"
                            >
                                <img
                                    :src="water"
                                    :alt="$t('Water')"
                                    class="h-5 w-5"
                                >
                                {{ armor.defense_water }}
                            </span>
                            <span
                                v-if="armor.defense_thunder"
                                class="flex gap-1 items-center px-2 py-1 text-sm rounded-full text-yellow-700 dark:text-yellow-300 bg-yellow-300 dark:bg-yellow-700"
                            >
                                <img
                                    :src="thunder"
                                    :alt="$t('Thunder')"
                                    class="h-5 w-5"
                                >
                                {{ armor.defense_thunder }}
                            </span>
                            <span
                                v-if="armor.defense_ice"
                                class="flex gap-1 items-center px-2 py-1 text-sm rounded-full text-teal-700 dark:text-teal-300 bg-teal-300 dark:bg-teal-700"
                            >
                                <img
                                    :src="ice"
                                    :alt="$t('Ice')"
                                    class="h-5 w-5"
                                >
                                {{ armor.defense_ice }}
                            </span>
                            <span
                                v-if="armor.defense_dragon"
                                class="flex gap-1 items-center px-2 py-1 text-sm rounded-full text-purple-700 dark:text-purple-300 bg-purple-300 dark:bg-pruple-700"
                            >
                                <img
                                    :src="dragon"
                                    :alt="$t('Dragon')"
                                    class="h-5 w-5"
                                >
                                {{ armor.defense_dragon }}
                            </span>
                        </div>
                        <div
                            v-for="skill in armor.skills"
                            :key="skill.id"
                            class="border-t border-gray-500 pt-2 w-full italic text-sm"
                        >
                            <div class="font-semibold flex items-center justify-between gap-2">
                                <span>{{ skill.name }}</span>
                                <KnightIcon
                                    v-if="skill.bonus_set"
                                    class="h-8 w-8"
                                    :class="getRarityColor(armor.rarity)"
                                />
                            </div>
                            <div v-if="showAdvanceSkillDescription">
                                {{ skill.description }}
                            </div>
                        </div>
                        <div
                            v-if="canEdit"
                            class="border-t border-gray-500 pt-2"
                        >
                            <SecondaryButton
                                v-if="hunterArmorCount(armor)"
                                class="w-full justify-center gap-2 group"
                            >
                                <CogIcon class="w-4 h-4 group-hover:rotate-180 group-hover:text-green-500 transition-all" />
                                {{ $t('Equip') }}
                            </SecondaryButton>
                            <SecondaryButton
                                v-else
                                class="w-full justify-center gap-2 group"
                            >
                                <Wrench class="w-4 h-4 group-hover:text-green-500 transition-all" />
                                {{ $t('Craft') }}
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
