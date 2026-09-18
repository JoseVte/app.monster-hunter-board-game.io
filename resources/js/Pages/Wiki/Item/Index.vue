<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ItemsIcon from "@/Components/Icons/ItemsIcon.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
import TableBase from "@/Components/Table/TableBase.vue";
import Row from "@/Components/Table/Row.vue";
import CellHeader from "@/Components/Table/CellHeader.vue";
import Cell from "@/Components/Table/Cell.vue";
import ItemFilters from "@/Pages/Wiki/Partials/ItemFilters.vue";

const props = defineProps({
    items: [Array, Object],
    filters: Object,
    options: Object,
});

const loading = ref(false);

// Clicking the active column flips its direction; clicking the other one
// starts it fresh, ascending.
const sortBy = (field) => {
    const direction = props.filters.sort === field && props.filters.direction === 'asc' ? 'desc' : 'asc';

    router.get(route('wiki.item.index'), {
        q: props.filters.q || undefined,
        type: props.filters.type || undefined,
        sort: field,
        direction,
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['items', 'filters'],
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
    });
};
</script>

<template>
    <AppLayout :title="$t('Items')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Items')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="ItemsIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <ItemFilters
                    :filters="filters"
                    :options="options"
                    @loading="loading = $event"
                />

                <LoadingOverlay :loading="loading">
                    <p
                        v-if="!items.length"
                        class="mt-6 text-sm text-gray-600 dark:text-parchment-dim"
                    >
                        {{ $t('Nothing matches those filters.') }}
                    </p>

                    <TableBase
                        v-else
                        class="mt-6"
                    >
                        <template #header>
                            <CellHeader
                                v-for="column in [{ field: 'name', label: $t('Name') }, { field: 'type', label: $t('Type') }]"
                                :key="column.field"
                            >
                                <button
                                    type="button"
                                    class="flex items-center gap-1"
                                    @click="sortBy(column.field)"
                                >
                                    {{ column.label }}
                                    <svg
                                        v-if="filters.sort === column.field"
                                        class="h-3 w-3 transition-transform"
                                        :class="{ 'rotate-180': filters.direction === 'desc' }"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.5 15.75l7.5-7.5 7.5 7.5"
                                        />
                                    </svg>
                                </button>
                            </CellHeader>
                        </template>

                        <Row
                            v-for="item in items"
                            :key="item.id"
                        >
                            <Cell :url="route('wiki.item.show', [item.id])">
                                {{ item.name }}
                            </Cell>
                            <Cell :url="route('wiki.item.show', [item.id])">
                                {{ item.type }}
                            </Cell>
                        </Row>
                    </TableBase>
                </LoadingOverlay>
            </div>
        </div>
    </AppLayout>
</template>
