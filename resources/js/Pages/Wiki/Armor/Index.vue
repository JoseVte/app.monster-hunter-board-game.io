<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";
import Card from "@/Components/Card.vue";
import KnightIcon from "@/Components/Icons/KnightIcon.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
import ArmorDefenseRow from "@/Pages/Hunter/Partials/ArmorDefenseRow.vue";
import WikiFilters from "@/Pages/Wiki/Partials/WikiFilters.vue";

defineProps({
    branches: [Array, Object],
    filters: Object,
    options: Object,
});

// The same three slots the hunter sheet lines up, so a row reads as one set.
const slots = [
    { key: 'head', icon: HelmetIcon },
    { key: 'body', icon: ArmorsIcon },
    { key: 'leg', icon: LegArmor },
];

const loading = ref(false);
</script>

<template>
    <AppLayout :title="$t('Armors')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Armors')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="ArmorsIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <WikiFilters
                    :filters="filters"
                    :options="options"
                    route-name="wiki.armor.index"
                    :only="['branches', 'filters']"
                    @loading="loading = $event"
                />

                <LoadingOverlay :loading="loading">
                    <p
                        v-if="!branches.length"
                        class="mt-6 text-sm text-gray-600 dark:text-parchment-dim"
                    >
                        {{ $t('Nothing matches those filters.') }}
                    </p>

                    <!-- A row per monster, the three slots across, the way the hunter
                         sheet draws them. A set missing a piece leaves its gap.
                         Fifteen of these stacked open is a scroll longer than the
                         page is worth, so each starts closed, open already only
                         when a filter has already done the narrowing. -->
                    <details
                        v-for="group in branches"
                        :key="group.branch"
                        :open="!!(filters.q || filters.rarity || filters.expansion || filters.branch)"
                        class="mt-6"
                    >
                        <summary class="mh-heading cursor-pointer text-xs tracking-widest uppercase">
                            {{ group.branch }}
                        </summary>

                        <div class="mt-3 grid grid-cols-1 gap-4 md:grid-cols-3">
                            <template
                                v-for="slot in slots"
                                :key="`${group.branch}-${slot.key}`"
                            >
                                <Link
                                    v-if="group.pieces[slot.key]"
                                    :href="route('wiki.armor.show', group.pieces[slot.key].id)"
                                >
                                    <Card
                                        clickable
                                        class="gap-2"
                                    >
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                                                <component
                                                    :is="slot.icon"
                                                    class="h-4 w-4"
                                                    :class="getRarityColor(group.pieces[slot.key].rarity)"
                                                />
                                            </span>
                                            <span class="mh-card-name">{{ group.pieces[slot.key].name }}</span>
                                        </div>

                                        <div class="mh-rule" />

                                        <ArmorDefenseRow :armor="group.pieces[slot.key]" />

                                        <div
                                            v-for="skill in group.pieces[slot.key].skills"
                                            :key="skill.id"
                                            class="text-sm italic"
                                        >
                                            <div class="flex items-center justify-between gap-2 font-semibold">
                                                <span>{{ skill.name }}</span>
                                                <KnightIcon
                                                    v-if="skill.bonus_set"
                                                    class="h-5 w-5 shrink-0"
                                                    :class="getRarityColor(group.pieces[slot.key].rarity)"
                                                />
                                            </div>
                                        </div>
                                    </Card>
                                </Link>
                                <div v-else />
                            </template>
                        </div>
                    </details>
                </LoadingOverlay>
            </div>
        </div>
    </AppLayout>
</template>
