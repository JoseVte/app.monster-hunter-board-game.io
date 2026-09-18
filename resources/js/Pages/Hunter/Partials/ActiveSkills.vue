<script setup>
import { computed } from 'vue';
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";
import ArmorSetPieces from "@/Pages/Hunter/Partials/ArmorSetPieces.vue";
import {equippedSkills} from "@/armorSkills";

// What the hunter is actually getting from what they are wearing. A piece
// carries at most one skill, and a set bonus only counts once every piece of
// its monster is on, so an incomplete one shows what it is still waiting for
// rather than being left out.
const props = defineProps({
    showAdvanceSkillDescription: Boolean,
    armors: {
        type: [Array, Object],
        default: () => [],
    },
    slotById: Object,
})

const ICONS = { head: HelmetIcon, body: ArmorsIcon, leg: LegArmor };

const equippedIds = computed(() => Object.values(props.armors).map((armor) => armor.id));

const skills = computed(() => equippedSkills(props.armors)
    .map((entry) => ({ ...entry, icon: ICONS[entry.slot] })));
</script>

<template>
    <div class="mh-frame bg-white/60 p-4 dark:bg-gray-900/40">
        <h3 class="mh-heading text-sm">
            {{ $t('Active Skills') }}
        </h3>

        <p
            v-if="!skills.length"
            class="mt-3 text-sm text-gray-600 dark:text-parchment-dim"
        >
            {{ $t('Nothing equipped') }}
        </p>

        <!-- Names alone sit on one line; with the descriptions on they need a row
             each, since a wrapped row of paragraphs reads as neither. -->
        <ul
            v-else
            class="mt-3"
            :class="showAdvanceSkillDescription ? 'flex flex-col gap-3' : 'flex flex-wrap gap-x-6 gap-y-2'"
        >
            <li
                v-for="entry in skills"
                :key="entry.skill.id"
                class="text-sm"
                :class="entry.active ? 'text-gray-800 dark:text-gray-200' : 'text-gray-500 dark:text-gray-600'"
            >
                <span class="flex items-center gap-2">
                    <component
                        :is="entry.icon"
                        v-if="entry.icon"
                        class="h-4 w-4 shrink-0"
                    />
                    <span class="font-semibold">{{ entry.skill.name }}</span>
                    <ArmorSetPieces
                        v-if="entry.skill.bonus_set"
                        :skill="entry.skill"
                        :slot-by-id="slotById"
                        :equipped-ids="equippedIds"
                    />
                </span>
                <div
                    v-if="showAdvanceSkillDescription"
                    class="mt-1 ml-6 wrap-break-word"
                    v-html="replaceIcons(entry.skill.description)"
                />
            </li>
        </ul>
    </div>
</template>
