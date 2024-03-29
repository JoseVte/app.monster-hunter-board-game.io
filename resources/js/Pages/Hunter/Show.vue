<script setup>
import {Link, router } from "@inertiajs/vue3";
import _ from "lodash";
import {Tab, Tabs} from "vue3-tabs-component";
import {computed, onMounted, ref, watch} from "vue";
import {useStorage} from "vue3-storage";
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
const tabChanged = (tab) => {
    if (tabInitialized.value) {
        const newUrl = route('campaigns.hunters.show', [props.campaign, props.hunter, tab.tab.computedId]);
        router.visit(newUrl, {preserveScroll: true});
    }
}

onMounted(() => {
    tabs.value.selectTab('#'+props.tabOpened)
    tabInitialized.value = true;
})

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
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                    <img
                        :src="user?.profile_photo_url"
                        :alt="user?.name"
                        class="relative inline-block h-20 w-20 rounded-full ring-2 ring-white dark:ring-gray-800 hover:ring-gray-200 dark:hover:ring-gray-600"
                    >
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 w-full relative">
                        <h1 class="text-gray-800 dark:text-white text-2xl">
                            {{ hunter.name }}
                        </h1>
                        <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                            {{ user?.name }}
                        </h2>
                        <Link
                            :href="route('campaigns.show', campaign)"
                            class="text-gray-600 dark:text-gray-400 text-xl"
                        >
                            {{ campaign.name }}
                        </Link>
                        <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                            {{ hunter.palico ? hunter.palico.name : '-' }}
                        </h2>
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
                            <div class="flex flex-col sm:flex-row justify-between">
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
                            <div class="flex flex-col sm:flex-row justify-between">
                                <h2 class="text-gray-600 dark:text-gray-400 text-xl">
                                    {{ $t('Monter Parts') }}
                                </h2>

                                <AddItemToHunterButton
                                    v-if="canEdit"
                                    :campaign="campaign"
                                    :hunter="hunter"
                                    :items="monsterItems"
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
                        <SectionBorder>
                            <div class="flex flex-col lg:flex-row items-start sm:items-end lg:items-center gap-2 lg:gap-0 px-4 sm:px-0">
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

                        <ListArmorType
                            :can-edit="canEdit"
                            :show-all-armors="showAllArmors"
                            :show-advance-skill-description="showAdvanceSkillDescription"
                            :icon="HelmetIcon"
                            :campaign="campaign"
                            :hunter="hunter"
                            :armors="armors['head']"
                            :equipped-armor="hunterEquippedArmor['head']"
                        />

                        <SectionBorder />

                        <ListArmorType
                            :can-edit="canEdit"
                            :show-all-armors="showAllArmors"
                            :show-advance-skill-description="showAdvanceSkillDescription"
                            :icon="ArmorsIcon"
                            :campaign="campaign"
                            :hunter="hunter"
                            :armors="armors['body']"
                            :equipped-armor="hunterEquippedArmor['body']"
                        />

                        <SectionBorder />

                        <ListArmorType
                            :can-edit="canEdit"
                            :show-all-armors="showAllArmors"
                            :show-advance-skill-description="showAdvanceSkillDescription"
                            :icon="LegArmor"
                            :campaign="campaign"
                            :hunter="hunter"
                            :armors="armors['leg']"
                            :equipped-armor="hunterEquippedArmor['leg']"
                        />
                    </Tab>
                </Tabs>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
