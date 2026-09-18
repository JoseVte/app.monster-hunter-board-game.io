<script setup>
import {Link, router } from "@inertiajs/vue3";
import _ from "lodash";
import {Tab, Tabs} from "vue3-tabs-component";
import {computed, onMounted, ref, watch} from "vue";
import {useI18n} from "vue-i18n";
import {useStorage} from "vue3-storage";
import {useMediaQuery} from "@/composables/useMediaQuery";
import ArmorTotalsRow from "@/Pages/Hunter/Partials/ArmorTotalsRow.vue";
import {equippedSkills} from "@/armorSkills";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Edit from "@/Components/Icons/Edit.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import AddItemToHunterButton from "@/Pages/Hunter/Partials/AddItemToHunterButton.vue";
import GridItemHunter from "@/Pages/Hunter/Partials/GridItemHunter.vue";
import Switch from "@/Components/Form/Switch.vue";
import ListWeaponTypes from "@/Pages/Hunter/Partials/ListWeaponTypes.vue";
import ListWeapons from "@/Pages/Hunter/Partials/ListWeapons.vue";
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";
import ListArmorType from "@/Pages/Hunter/Partials/ListArmorType.vue";
import ArmorDefense from "@/Pages/Hunter/Partials/ArmorDefense.vue";
import ArmorBranchGrid from "@/Pages/Hunter/Partials/ArmorBranchGrid.vue";
import ActiveSkills from "@/Pages/Hunter/Partials/ActiveSkills.vue";

const props = defineProps({
    canEdit: Boolean,
    campaign: Object,
    hunter: Object,
    tabOpened: String,
    weaponType: Object,
    weapons: [Array, Object],
    armors: [Array, Object],
    user: Object,
    commonItems: Array,
    otherItems: [Array, Object],
    monsterItems: [Array, Object],
    weaponTypes: [Array, Object],
});

const storage = useStorage();
const hideEmpty = ref(storage.getStorageSync('hide-empty-items'));
watch(hideEmpty, (hideEmptyValue) => storage.setStorageSync('hide-empty-items', hideEmptyValue))
const showAllArmors = ref(storage.getStorageSync('show-all-armors'));
watch(showAllArmors, (showAllArmorsValue) => storage.setStorageSync('show-all-armors', showAllArmorsValue))
const showAdvanceSkillDescription = ref(storage.getStorageSync('show-advance-skill-description'));
watch(showAdvanceSkillDescription, (showAdvanceSkillDescriptionValue) => storage.setStorageSync('show-advance-skill-description', showAdvanceSkillDescriptionValue))

const hunterOtherItems = computed(() => {
    return _.sortBy(props.hunter.other_items, (item) => item.name);
});
const hunterMonsterItems = computed(() => {
    return _.sortBy(props.hunter.monster_items, (item) => item.name);
});

const tabs = ref(null);
const tabInitialized = ref(false);
const tabOptions = {
    useUrlFragment: false,
    defaultTabHash: props.tabOpened,
};
// Every panel's data is loaded on every request, so the tab only decides which
// one is on screen. Asking for `tabOpened` alone keeps the URL in step without
// re-rendering the page: a full visit reset the scroll to the top after the
// panel had already switched underneath the reader, which is what made the
// change look like a jump.
const tabChanged = (tab) => {
    if (tabInitialized.value) {
        keepTabsInView();

        const newUrl = route('campaigns.hunters.show', [props.campaign, props.hunter, tab.tab.computedId]);
        router.visit(newUrl, {preserveScroll: true, preserveState: true, only: ['tabOpened']});
    }
}

// Holding the offset exactly would leave the reader deep inside the new panel
// with the tab bar off the top of the screen and no sign of what just changed.
// Anyone already looking at the bar keeps their place untouched.
const keepTabsInView = () => {
    const top = tabs.value?.$el?.getBoundingClientRect().top ?? 0;

    if (top < 0) {
        window.scrollBy(0, top);
    }
}

// Nothing remounts now, so back and forward move `tabOpened` without the panel
// following. Skipping the tab already on screen keeps this from bouncing
// straight back into tabChanged.
watch(() => props.tabOpened, (tab) => {
    if (tabs.value && tabs.value.activeTabHash !== '#' + tab) {
        tabs.value.selectTab('#' + tab);
    }
});

onMounted(() => {
    tabs.value.selectTab('#'+props.tabOpened)
    tabInitialized.value = true;
})

const {t} = useI18n();

// md, the breakpoint the armour tab switches layout at. Rendering both and
// hiding one with a class meant a card, and its craft modal, for every piece
// twice over.
const wideEnoughForArmorGrid = useMediaQuery('(min-width: 768px)');

// The three slots, in the order the sheet reads them.
const armorSlots = computed(() => [
    { key: 'head', label: t('Head'), icon: HelmetIcon },
    { key: 'body', label: t('Body'), icon: ArmorsIcon },
    { key: 'leg', label: t('Leg'), icon: LegArmor },
]);

// A set bonus names the pieces it needs by id, and what a reader wants to see is
// which slots those are, so the tab keeps the map between them.
// Just the names of what is running. The tab's panel is where the incomplete
// sets and the descriptions live.
const activeSkillNames = computed(() => equippedSkills(props.hunter.equipped_armors)
    .filter((entry) => entry.active)
    .map((entry) => entry.skill.name));

// The favourite of the type in hand, or its starting weapon when nothing has
// been picked within that type.
const carriedWeaponName = computed(() => {
    const type = props.hunter.weapon_type;
    if (! type) return '-';

    const equipped = _.find(props.hunter.equipped_weapons, (weapon) => weapon.type_id === type.id);
    if (equipped) return equipped.name;

    const fromType = _.find(props.weaponTypes, (candidate) => candidate.id === type.id);

    return _.find(fromType?.weapons, (weapon) => weapon.is_default)?.name ?? type.name;
});

const openTab = (tab) => tabs.value?.selectTab(`#${tab}`);

const armorSlotById = computed(() => Object.fromEntries(
    Object.values(props.armors).flatMap((pieces) => Object.entries(pieces)
        .map(([slot, armor]) => [armor.id, slot])),
));

const equippedArmorIds = computed(() => props.hunter.equipped_armors.map((armor) => armor.id));

const hunterEquippedArmor = computed(() => {
    return {
        head: _.first(_.filter(props.hunter.equipped_armors, (armor) => armor.type_value === 'head')),
        body: _.first(_.filter(props.hunter.equipped_armors, (armor) => armor.type_value === 'body')),
        leg: _.first(_.filter(props.hunter.equipped_armors, (armor) => armor.type_value === 'leg'))
    }
})
</script>

<template>
    <AppLayout :title="hunter.name">
        <template #header>
            <Breadcrumb
                :current-title="hunter.name"
                :breadcrumbs="[
                    { url: route('campaigns.show', campaign), title: campaign.name },
                ]"
                :icon="WeaponsIcon"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:py-10 sm:px-6 lg:px-8">
                <div class="mh-frame flex items-center gap-4 bg-white px-4 py-5 sm:p-6 dark:bg-gray-800">
                    <img
                        :src="user?.profile_photo_url"
                        :alt="user?.name"
                        class="relative inline-block h-20 w-20 rounded-full ring-2 ring-white dark:ring-gray-800 hover:ring-gray-200 dark:hover:ring-gray-600"
                    >
                    <!-- Three columns: who the hunter is, what is in their hand,
                         and what they are protected by. The last two each open
                         where they come from. -->
                    <!-- Two rows of three: who the hunter is on the first, what
                         they are carrying on the second. The armour takes two
                         columns of it, since six defence values and a line of
                         skill names need the room. -->
                    <div class="relative grid w-full grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-3">
                        <!-- The hunter and their palico go out together, so the cat
                             sits under the name rather than in a column of its own. -->
                        <div class="flex flex-col">
                            <h1 class="text-2xl text-gray-800 dark:text-white">
                                {{ hunter.name }}
                            </h1>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ hunter.palico ? hunter.palico.name : '-' }}
                            </span>
                        </div>

                        <Link
                            :href="route('campaigns.show', campaign)"
                            class="flex flex-col gap-1"
                        >
                            <span class="text-xs font-semibold tracking-widest text-parchment-dim uppercase">
                                {{ $t('Campaign') }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">{{ campaign.name }}</span>
                        </Link>

                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-semibold tracking-widest text-parchment-dim uppercase">
                                {{ $t('Hunter') }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">{{ user?.name }}</span>
                        </div>

                        <Link
                            v-if="hunter.weapon_type"
                            :href="route('campaigns.hunters.weapon-type.index', [campaign, hunter, hunter.weapon_type])"
                            class="flex flex-col gap-1"
                            preserve-scroll
                        >
                            <span class="text-xs font-semibold tracking-widest text-parchment-dim uppercase">
                                {{ $t('Carrying') }}
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                                    <img
                                        v-if="hunter.weapon_type.image_url"
                                        class="h-5 w-5 drop-shadow-sm"
                                        :src="hunter.weapon_type.image_url"
                                        :alt="hunter.weapon_type.name"
                                    >
                                </span>
                                <span class="text-gray-900 dark:text-parchment">{{ carriedWeaponName }}</span>
                            </span>
                        </Link>
                        <div v-else />

                        <button
                            type="button"
                            class="flex cursor-pointer flex-col items-start gap-1 text-left sm:col-span-2"
                            @click="openTab('armors')"
                        >
                            <span class="text-xs font-semibold tracking-widest text-parchment-dim uppercase">
                                {{ $t('Total Defense') }}
                            </span>
                            <ArmorTotalsRow :armors="hunter.equipped_armors" />
                            <span
                                v-if="activeSkillNames.length"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >
                                {{ activeSkillNames.join(' · ') }}
                            </span>
                        </button>

                        <div
                            v-if="canEdit"
                            class="absolute top-0 right-0"
                        >
                            <Link :href="route('campaigns.hunters.edit', [campaign, hunter])">
                                <Edit class="h-4 w-4 text-gray-700 dark:text-gray-300" />
                            </Link>
                        </div>
                    </div>
                </div>

                <Tabs
                    ref="tabs"
                    :cache-lifetime="-1"
                    :options="tabOptions"
                    @changed="tabChanged"
                >
                    <Tab
                        id="items"
                        :name="$t('Items')"
                    >
                        <SectionBorder>
                            <Switch
                                v-model:checked="hideEmpty"
                                :label="$t('Hide empty items')"
                            />
                        </SectionBorder>

                        <div class="flex flex-col gap-4">
                            <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                                {{ $t('Common Bones, Ores and Hides') }}
                            </h2>

                            <GridItemHunter
                                :can-edit="canEdit"
                                :hide-empty="hideEmpty"
                                :campaign="campaign"
                                :hunter="hunter"
                                :items="commonItems"
                            />
                        </div>

                        <SectionBorder />

                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                                <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                                    {{ $t('Other Items') }}
                                </h2>

                                <AddItemToHunterButton
                                    v-if="canEdit"
                                    :campaign="campaign"
                                    :hunter="hunter"
                                    :items="otherItems"
                                    :label="$t('Add Other Item')"
                                    :label-btn="$t('Add Other Item')"
                                />
                            </div>

                            <GridItemHunter
                                :can-edit="canEdit"
                                :hide-empty="hideEmpty"
                                :campaign="campaign"
                                :hunter="hunter"
                                :items="hunterOtherItems"
                            />
                        </div>

                        <SectionBorder />

                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-0">
                                <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                                    {{ $t('Monter Parts') }}
                                </h2>

                                <AddItemToHunterButton
                                    v-if="canEdit"
                                    :campaign="campaign"
                                    :hunter="hunter"
                                    :items="monsterItems"
                                    grouped
                                    :label="$t('Add Monter Part')"
                                    :label-btn="$t('Add Monter Part')"
                                />
                            </div>

                            <GridItemHunter
                                :can-edit="canEdit"
                                :hide-empty="hideEmpty"
                                :campaign="campaign"
                                :hunter="hunter"
                                :items="hunterMonsterItems"
                            />
                        </div>
                    </Tab>
                    <Tab
                        id="weapons"
                        :name="$t('Weapons')"
                    >
                        <ListWeaponTypes
                            v-if="!weaponType"
                            :can-edit="canEdit"
                            :campaign="campaign"
                            :hunter="hunter"
                            :weapon-types="weaponTypes"
                        />
                        <ListWeapons
                            v-else
                            :can-edit="canEdit"
                            :campaign="campaign"
                            :hunter="hunter"
                            :weapon-type="weaponType"
                            :weapons="weapons"
                        />
                    </Tab>
                    <Tab
                        id="armors"
                        :name="$t('Armors')"
                    >
                        <!-- The panel sets pt-0 so the active tab meets it, which
                             leaves the first thing inside touching the top edge. -->
                        <ArmorDefense
                            class="mt-4"
                            :armors="hunter.equipped_armors"
                        />

                        <ActiveSkills
                            class="mt-4"
                            :show-advance-skill-description="showAdvanceSkillDescription"
                            :armors="hunter.equipped_armors"
                            :slot-by-id="armorSlotById"
                        />

                        <SectionBorder>
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-6">
                                <Switch
                                    v-model:checked="showAllArmors"
                                    :label="$t('Show all armors')"
                                />
                                <Switch
                                    v-model:checked="showAdvanceSkillDescription"
                                    :label="$t('Show advanced description for skills')"
                                />
                            </div>
                        </SectionBorder>

                        <!-- The three slots in a row per monster, so a set reads
                             across in one line. A phone gets the same three lists
                             stacked: three columns and a rotated label do not fit
                             across 390px. -->
                        <ArmorBranchGrid
                            v-if="wideEnoughForArmorGrid"
                            :can-edit="canEdit"
                            :show-all-armors="showAllArmors"
                            :show-advance-skill-description="showAdvanceSkillDescription"
                            :campaign="campaign"
                            :hunter="hunter"
                            :armor-slots="armorSlots"
                            :armors="armors"
                            :equipped="hunterEquippedArmor"
                            :slot-by-id="armorSlotById"
                            :equipped-ids="equippedArmorIds"
                        />

                        <div
                            v-else
                            class="flex flex-col gap-8"
                        >
                            <ListArmorType
                                v-for="slot in armorSlots"
                                :key="slot.key"
                                :can-edit="canEdit"
                                :show-all-armors="showAllArmors"
                                :show-advance-skill-description="showAdvanceSkillDescription"
                                :campaign="campaign"
                                :hunter="hunter"
                                :armor-slot="slot"
                                :armors="armors"
                                :equipped="hunterEquippedArmor[slot.key]"
                                :slot-by-id="armorSlotById"
                                :equipped-ids="equippedArmorIds"
                            />
                        </div>
                    </Tab>
                </Tabs>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
