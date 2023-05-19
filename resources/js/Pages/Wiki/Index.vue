<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import WikiSection from "@/Components/WikiSection.vue";
import ItemsIcon from "@/Components/Icons/ItemsIcon.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
</script>

<template>
    <AppLayout :title="$t('Wiki')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Wiki')"
                :breadcrumbs="[]"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-8">
                    <WikiSection
                        :href="route('wiki.monster.index')"
                        :title="$t('Monsters')"
                    >
                        <template #icon>
                            <MonstersIcon class="w-7 h-7 text-primary-500" />
                        </template>
                    </WikiSection>

                    <WikiSection
                        :href="route('wiki.item.index')"
                        :title="$t('Items')"
                    >
                        <template #icon>
                            <ItemsIcon class="w-7 h-7 stroke-primary-500" />
                        </template>
                    </WikiSection>

                    <WikiSection
                        :href="route('wiki.armor.index')"
                        :title="$t('Armors')"
                    >
                        <template #icon>
                            <ArmorsIcon class="w-7 h-7 text-primary-500" />
                        </template>
                    </WikiSection>

                    <WikiSection
                        :href="route('wiki.weapon.index')"
                        :title="$t('Weapons')"
                    >
                        <template #icon>
                            <WeaponsIcon class="w-7 h-7 text-primary-500" />
                        </template>
                    </WikiSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
