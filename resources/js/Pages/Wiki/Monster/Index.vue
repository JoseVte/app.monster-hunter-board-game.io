<script setup>
import {ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
import TableBase from "@/Components/Table/TableBase.vue";
import Row from "@/Components/Table/Row.vue";
import CellHeader from "@/Components/Table/CellHeader.vue";
import Cell from "@/Components/Table/Cell.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import MonsterFilters from "@/Pages/Wiki/Partials/MonsterFilters.vue";

defineProps({
    monsters: [Array, Object],
    filters: Object,
    options: Object,
});

const loading = ref(false);
</script>

<template>
    <AppLayout :title="$t('Monsters')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Monsters')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="MonstersIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <MonsterFilters
                    :filters="filters"
                    :options="options"
                    @loading="loading = $event"
                />

                <p class="my-4 text-sm dark:text-white">
                    {{ monsters.length + ' ' + $t('results found.') }}
                </p>

                <LoadingOverlay :loading="loading">
                    <TableBase>
                        <template #header>
                            <CellHeader />
                            <CellHeader>{{ $t('Name') }}</CellHeader>
                            <CellHeader>{{ $t('Category') }}</CellHeader>
                            <CellHeader>{{ $t('Expansion') }}</CellHeader>
                            <CellHeader />
                        </template>

                        <Row v-if="monsters.length === 0">
                            <Cell colspan="5">
                                {{ $t('No results found.') }}
                            </Cell>
                        </Row>
                        <Row
                            v-for="monster in monsters"
                            v-else
                            :key="monster.id"
                        >
                            <Cell :url="route('wiki.monster.show', [monster.id])">
                                <img
                                    :src="monster.icon_url"
                                    :alt="monster.name"
                                    class="h-6 w-6 rounded-full object-contain"
                                >
                            </Cell>
                            <Cell :url="route('wiki.monster.show', [monster.id])">
                                {{ monster.name }}
                            </Cell>
                            <Cell :url="route('wiki.monster.show', [monster.id])">
                                {{ monster.category }}
                            </Cell>
                            <Cell :url="route('wiki.monster.show', [monster.id])">
                                {{ monster.expansion }}
                            </Cell>
                            <Cell />
                        </Row>
                    </TableBase>
                </LoadingOverlay>
            </div>
        </div>
    </AppLayout>
</template>
