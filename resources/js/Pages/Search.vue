<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import WikiSection from "@/Components/WikiSection.vue";
import ItemsIcon from "@/Components/Icons/ItemsIcon.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";
import SearchGridItem from "@/Components/SearchGridItem.vue";
import CogIcon from "@/Components/Icons/CogIcon.vue";
import Calendar from "@/Components/Icons/Calendar.vue";
import {useStorage} from "vue3-storage";
import {ref, watch} from "vue";
import Switch from "@/Components/Form/Switch.vue";

defineProps({
    results: Object,
    query: String
})

const storage = useStorage();
const searchSectionsSelection = ref(storage.getStorageSync('search-sections'));
watch(searchSectionsSelection, (searchSectionsValue) => storage.setStorageSync('search-sections', searchSectionsValue))

const searchSections = {
    armor: {type: 'App\\Models\\Armor', enabled: true},
    skills: {type: 'App\\Models\\ArmorSkill', enabled: true},
    downtimeActivities: {type: 'App\\Models\\DowntimeActivity', enabled: true},
    items: {type: 'App\\Models\\Item', enabled: true},
    monsters: {type: 'App\\Models\\Monster', enabled: true},
    weapons: {type: 'App\\Models\\Weapon', enabled: true},
}

if (searchSectionsSelection.value === undefined) {
    searchSectionsSelection.value = searchSections
}
</script>

<template>
    <AppLayout :title="$t('Search: ') + query">
        <template #header>
            <Breadcrumb
                :current-title="$t('Search: ') + query"
                :breadcrumbs="[]"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-100 dark:bg-gray-800 rounded grid grid-cols-3 p-4 gap-4 mb-6">
                    <Switch
                        v-model:checked="searchSectionsSelection.armor.enabled"
                        :label="$t('Show armors')"
                    />
                    <Switch
                        v-model:checked="searchSectionsSelection.skills.enabled"
                        :label="$t('Show skills')"
                    />
                    <Switch
                        v-model:checked="searchSectionsSelection.downtimeActivities.enabled"
                        :label="$t('Show downtime activities')"
                    />
                    <Switch
                        v-model:checked="searchSectionsSelection.items.enabled"
                        :label="$t('Show items')"
                    />
                    <Switch
                        v-model:checked="searchSectionsSelection.monsters.enabled"
                        :label="$t('Show skills')"
                    />
                    <Switch
                        v-model:checked="searchSectionsSelection.weapons.enabled"
                        :label="$t('Show weapons')"
                    />
                </div>

                <template v-if="searchSectionsSelection.armor.enabled">
                    <h2 class="mb-6 text-xl dark:text-white font-medium">
                        {{ $t('Armors') }}
                    </h2>
                    <div
                        v-if="searchSectionsSelection.armor.type in results"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                    >
                        <SearchGridItem
                            v-for="armor in results[searchSectionsSelection.armor.type]"
                            :key="armor.id"
                            :href="route('wiki.armor.show', armor)"
                            :title="armor.name"
                        >
                            <template #icon>
                                <HelmetIcon
                                    v-if="armor.classType === 'head'"
                                    class="w-7 h-7 text-primary-500"
                                />
                                <ArmorsIcon
                                    v-if="armor.classType === 'body'"
                                    class="w-7 h-7 text-primary-500"
                                />
                                <LegArmor
                                    v-if="armor.classType === 'leg'"
                                    class="w-7 h-7 text-primary-500"
                                />
                            </template>
                        </SearchGridItem>
                    </div>
                </template>

                <template v-if="searchSectionsSelection.skills.enabled">
                    <h2 class="mb-6 text-xl dark:text-white font-medium">
                        {{ $t('Skills') }}
                    </h2>
                    <div
                        v-if="searchSectionsSelection.skills.type in results"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                    >
                        <SearchGridItem
                            v-for="armorSkill in results[searchSectionsSelection.skills.type]"
                            :key="armorSkill.id"
                            :href="route('wiki.armor.show', armorSkill)"
                            :title="armorSkill.name"
                        >
                            <template #icon>
                                <CogIcon
                                    class="w-7 h-7 text-primary-500"
                                />
                            </template>
                        </SearchGridItem>
                    </div>
                </template>

                <template v-if="searchSectionsSelection.downtimeActivities.enabled">
                    <h2 class="mb-6 text-xl dark:text-white font-medium">
                        {{ $t('Downtime Activities') }}
                    </h2>
                    <div
                        v-if="searchSectionsSelection.downtimeActivities.type in results"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                    >
                        <SearchGridItem
                            v-for="downtimeActivity in results[searchSectionsSelection.downtimeActivities.type]"
                            :key="downtimeActivity.id"
                            :href="route('wiki.armor.show', downtimeActivity)"
                            :title="downtimeActivity.name"
                        >
                            <template #icon>
                                <Calendar
                                    class="w-7 h-7 text-primary-500"
                                />
                            </template>
                        </SearchGridItem>
                    </div>
                </template>

                <template v-if="searchSectionsSelection.items.enabled">
                    <h2 class="mb-6 text-xl dark:text-white font-medium">
                        {{ $t('Items') }}
                    </h2>
                    <div
                        v-if="searchSectionsSelection.items.type in results"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                    >
                        <SearchGridItem
                            v-for="item in results[searchSectionsSelection.items.type]"
                            :key="item.id"
                            :href="route('wiki.item.show', item)"
                            :title="item.name"
                        >
                            <template #icon>
                                <ItemsIcon
                                    class="w-7 h-7 stroke-primary-500"
                                />
                            </template>
                        </SearchGridItem>
                    </div>
                </template>

                <template v-if="searchSectionsSelection.monsters.enabled">
                    <h2 class="mb-6 text-xl dark:text-white font-medium">
                        {{ $t('Monsters') }}
                    </h2>
                    <div
                        v-if="searchSectionsSelection.monsters.type in results"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                    >
                        <SearchGridItem
                            v-for="monster in results[searchSectionsSelection.monsters.type]"
                            :key="monster.id"
                            :href="route('wiki.monster.show', monster)"
                            :title="monster.name"
                        >
                            <template #icon>
                                <MonstersIcon
                                    class="w-7 h-7 text-primary-500"
                                />
                            </template>
                        </SearchGridItem>
                    </div>
                </template>

                <template v-if="searchSectionsSelection.weapons.enabled">
                    <h2 class="mb-6 text-xl dark:text-white font-medium">
                        {{ $t('Weapons') }}
                    </h2>
                    <div
                        v-if="searchSectionsSelection.weapons.type in results"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
                    >
                        <SearchGridItem
                            v-for="weapon in results[searchSectionsSelection.weapons.type]"
                            :key="weapon.id"
                            :href="route('wiki.weapon.show', weapon)"
                            :title="weapon.name"
                        >
                            <template #icon>
                                <WeaponsIcon
                                    class="w-7 h-7 stroke-primary-500"
                                />
                            </template>
                        </SearchGridItem>
                    </div>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
