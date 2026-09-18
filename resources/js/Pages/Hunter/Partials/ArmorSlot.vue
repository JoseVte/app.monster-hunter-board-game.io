<script setup>
import ArmorDefenseRow from "@/Pages/Hunter/Partials/ArmorDefenseRow.vue";
import ArmorSetPieces from "@/Pages/Hunter/Partials/ArmorSetPieces.vue";

// What is in one slot right now, or that it is empty. An empty slot keeps its
// frame and says so in the same weight a piece would, rather than as a note.
const props = defineProps({
    showAdvanceSkillDescription: Boolean,
    armor: Object,
    slotById: Object,
    equippedIds: Array,
})

// A set bonus only counts once every piece of its monster is on.
const setComplete = (skill) => (skill.bonus_set_armor ?? [])
    .every((id) => props.equippedIds.includes(id));

const active = (skill) => ! skill.bonus_set || setComplete(skill);
</script>

<template>
    <div
        v-if="armor"
        class="mh-frame border-primary-500/60 bg-[linear-gradient(to_bottom,color-mix(in_oklab,var(--color-primary-500)_14%,transparent),transparent_70%)] p-3"
    >
        <div class="mh-card-name text-base text-gray-900 dark:text-parchment">
            {{ armor.name }}
        </div>

        <ArmorDefenseRow
            class="mt-2"
            :armor="armor"
        />

        <div
            v-for="skill in armor.skills"
            :key="skill.id"
            class="mt-2 text-sm"
            :class="{ 'opacity-45': !active(skill) }"
        >
            <div class="flex items-center justify-between gap-2 font-semibold text-gray-800 dark:text-gray-200">
                <span class="flex items-center gap-2">
                    <span>{{ skill.name }}</span>
                    <ArmorSetPieces
                        v-if="skill.bonus_set"
                        :skill="skill"
                        :slot-by-id="slotById"
                        :equipped-ids="equippedIds"
                    />
                </span>
            </div>
            <div
                v-if="showAdvanceSkillDescription"
                class="mt-1 wrap-break-word text-gray-700 dark:text-gray-300"
                v-html="replaceIcons(skill.description)"
            />
        </div>
    </div>

    <div
        v-else
        class="mh-frame border-dashed p-3 text-sm text-gray-600 dark:text-parchment-dim"
    >
        {{ $t('Nothing equipped') }}
    </div>
</template>
