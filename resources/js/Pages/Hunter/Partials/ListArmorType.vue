<script setup>
import {ref} from "vue";
import {Collapse} from "vue-collapsed";
import ListArmors from "@/Pages/Hunter/Partials/ListArmors.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import KnightIcon from "@/Components/Icons/KnightIcon.vue";

defineProps({
    canEdit: Boolean,
    showAllArmors: Boolean,
    showAdvanceSkillDescription: Boolean,
    campaign: Object,
    hunter: Object,
    icon: [Object, String],
    armors: [Array, Object],
    equippedArmor: Object
})

let toggleChange = ref(false);
</script>

<template>
    <div class="flex flex-row md:flex-col lg:flex-row w-full items-start justify-between gap-4 px-4 sm:px-0 mb-8 md:mb-0">
        <div class="lg:max-w-[250px] w-full">
            <template
                v-if="equippedArmor"
            >
                <div class="flex items-center gap-4">
                    <div class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                        <component
                            :is="icon"
                            v-if="icon"
                            class="h-6 w-6"
                            :class="getRarityColor(equippedArmor.rarity)"
                        />
                    </div>
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between w-full gap-2">
                        <div class="flex lg:flex-col gap-2">
                            <div class="text-gray-500 italic">
                                {{ $t('Current') }}
                            </div>
                            <div class="dark:text-white font-semibold">
                                {{ equippedArmor.name }}
                            </div>
                        </div>
                        <div class="flex lg:flex-col gap-2">
                            <div class="text-gray-500 italic">
                                {{ $t('Skill') }}
                            </div>
                            <div class="dark:text-white font-semibold">
                                <div
                                    v-for="skill in equippedArmor.skills"
                                    :key="skill.id"
                                    class="w-full italic text-sm"
                                >
                                    <div class="font-semibold flex items-center justify-between gap-2">
                                        <span>{{ skill.name }}</span>
                                        <KnightIcon
                                            v-if="skill.bonus_set"
                                            class="h-5 w-5"
                                            :class="getRarityColor(equippedArmor.rarity)"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if="showAdvanceSkillDescription">
                    <div
                        v-for="skill in equippedArmor.skills"
                        :key="skill.id"
                        class="w-full dark:text-white break-words text-sm italic mt-4"
                        v-html="replaceIcons(skill.description)"
                    />
                </template>
            </template>
            <div
                v-else
                class="flex items-center gap-4"
            >
                <div class="bg-gray-300 dark:bg-gray-800 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                    <component
                        :is="icon"
                        v-if="icon"
                        class="text-gray-500 h-6 w-6"
                    />
                </div>
                <span class="text-gray-500 italic">{{ $t('Current') }}</span>
                <span class="text-gray-500 italic">{{ $t('Skill') }}</span>
            </div>
        </div>
        <div class="block md:hidden text-gray-600 dark:text-gray-400 underline">
            <SecondaryButton @click="toggleChange = !toggleChange">
                {{ $t('Change') }}
            </SecondaryButton>
        </div>
        <div class="hidden md:block w-full">
            <ListArmors
                :can-edit="canEdit"
                :show-all-armors="showAllArmors"
                :show-advance-skill-description="showAdvanceSkillDescription"
                :icon="icon"
                :campaign="campaign"
                :hunter="hunter"
                :armors="armors"
            />
        </div>
    </div>

    <Collapse
        :when="toggleChange"
        class="v-collapse block md:hidden"
    >
        <ListArmors
            class="px-4 sm:px-0"
            :can-edit="canEdit"
            :show-all-armors="showAllArmors"
            :show-advance-skill-description="showAdvanceSkillDescription"
            :icon="icon"
            :campaign="campaign"
            :hunter="hunter"
            :armors="armors"
        />
    </Collapse>
</template>

<style>
.v-collapse {
    transition: height var(--vc-auto-duration) cubic-bezier(0.33, 1, 0.68, 1);
}
</style>
