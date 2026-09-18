<script setup>
import _ from "lodash";
import Card from "@/Components/Card.vue";
import Check from "@/Components/Icons/Check.vue";
import KnightIcon from "@/Components/Icons/KnightIcon.vue";
import CraftArmorModal from "@/Pages/Hunter/Partials/CraftArmorModal.vue";
import ArmorDefenseRow from "@/Pages/Hunter/Partials/ArmorDefenseRow.vue";

// One armour, printed the way a weapon card is. Shared by the row per monster
// the tab shows from tablet up and by the list per slot a phone gets.
const props = defineProps({
    canEdit: Boolean,
    showAdvanceSkillDescription: Boolean,
    campaign: Object,
    hunter: Object,
    icon: [Object, String],
    armor: Object,
})

const owned = () => _.filter(props.hunter.armors, (held) => held.id === props.armor.id).length;
</script>

<template>
    <Card
        class="gap-2"
        :owned="!!owned()"
        :equipped="!!armor.equipped"
    >
        <div class="flex items-center gap-3">
            <!-- The owned mark rides on the icon, the way it does on a weapon
                 card, so the name keeps the whole width. -->
            <span class="relative flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                <component
                    :is="icon"
                    v-if="icon"
                    class="h-4 w-4"
                    :class="getRarityColor(armor.rarity)"
                />
                <span
                    v-if="owned() > 1"
                    class="absolute -bottom-1 -right-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-gray-300 px-0.5 text-[0.6rem] font-bold leading-none text-primary-500 tabular-nums dark:bg-gray-900"
                >{{ owned() }}</span>
                <Check
                    v-else-if="owned()"
                    class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-gray-300 text-primary-500 dark:bg-gray-900"
                />
            </span>
            <span class="mh-card-name">{{ armor.name }}</span>
        </div>

        <div class="mh-rule" />

        <ArmorDefenseRow :armor="armor" />

        <div
            v-for="skill in armor.skills"
            :key="skill.id"
            class="text-sm italic"
        >
            <div class="flex items-center justify-between gap-2 font-semibold">
                <span>{{ skill.name }}</span>
                <KnightIcon
                    v-if="skill.bonus_set"
                    class="h-5 w-5 shrink-0"
                    :class="getRarityColor(armor.rarity)"
                />
            </div>
            <div
                v-if="showAdvanceSkillDescription"
                class="mt-2 wrap-break-word not-italic"
                v-html="replaceIcons(skill.description)"
            />
        </div>

        <div class="mt-auto pt-1">
            <CraftArmorModal
                v-if="canEdit"
                :campaign="campaign"
                :hunter="hunter"
                :armor="armor"
            />
        </div>
    </Card>
</template>
