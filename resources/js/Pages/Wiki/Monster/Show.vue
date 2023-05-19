<script setup>

import {usePage} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import TableBase from "@/Components/Table/TableBase.vue";
import Cell from "@/Components/Table/Cell.vue";
import CellHeader from "@/Components/Table/CellHeader.vue";
import Row from "@/Components/Table/Row.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";

const monster = usePage().props.monster;
console.log(monster)
</script>

<template>
    <AppLayout :title="monster.name + ' | ' + $t('Monster')">
        <template #header>
            <Breadcrumb
                :current-title="monster.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.monster.index'), title: $t('Monsters'), icon: MonstersIcon },
                ]"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-50 dark:bg-gray-800 sm:rounded w-full p-4">
                    <div class="flex gap-4">
                        <img
                            src="https://loremflickr.com/200/200/animals"
                            :alt="monster.name"
                            class="h-[200px] w-[200px]"
                        >
                        <div>
                            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">
                                {{ monster.name }}
                            </h2>
                            <h3 class="font-semibold text-lg dark:text-white">
                                {{ monster.category }}
                            </h3>
                        </div>
                    </div>
                </div>

                <h4 class="text-lg text-gray-800 dark:text-gray-200 mt-8 mb-4">
                    {{ $t('Materials') }}
                </h4>

                <TableBase>
                    <template #header>
                        <CellHeader>{{ $t('Dice Result') }}</CellHeader>
                        <CellHeader>{{ $t('Name') }}</CellHeader>
                    </template>

                    <Row
                        v-for="(item, index) in monster.items"
                        :key="item.id"
                    >
                        <Cell :url="route('wiki.monster.show', [monster.id])">
                            {{ index }}
                        </Cell>
                        <Cell :url="route('wiki.monster.show', [monster.id])">
                            icon {{ item.name }}
                        </Cell>
                    </Row>
                </TableBase>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
