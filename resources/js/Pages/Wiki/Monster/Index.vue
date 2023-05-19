<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TableBase from "@/Components/Table/TableBase.vue";
import Row from "@/Components/Table/Row.vue";
import CellHeader from "@/Components/Table/CellHeader.vue";
import Cell from "@/Components/Table/Cell.vue";
import Pagination from "@/Components/Table/Pagination.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import {getQuery} from "@/utils";

const query = getQuery();
defineProps({
    name: {
        type: String,
        default: ''
    },
    category: {
        type: String,
        default: ''
    },
    expansion: {
        type: String,
        default: ''
    },
});

const monsters = ref([]);
const pagination = ref({
    currentPage: 0,
    from: 0,
    to: 0,
    lastPage: 0,
    total: 0,
    prevPageUrl: '',
    nextPageUrl: '',
});

const form = useForm({
    name: query.name,
    category: query.category,
    expansion: query.expansion,
    page: query.page,
});

const clearAndFilter = () => {
    form.reset('name', 'category', 'expansion');
    resetPagination();
    filter();
};

const resetPagination = () => {
    pagination.value = {
        currentPage: 0,
        from: 0,
        to: 0,
        lastPage: 0,
        total: 0,
        prevPageUrl: '',
        nextPageUrl: '',
    };
};

const filter = () => {
    router.visit(route('wiki.monster.index', {
        page: 1,
        name: form.name,
        category: form.category,
        expansion: form.expansion,
    }));
};

const search = (params) => {
    axios.get(route('monster.filter'), {params})
        .then(res => {
            monsters.value = res.data.data;
            pagination.value.currentPage = res.data.current_page;
            pagination.value.from = res.data.from;
            pagination.value.to = res.data.to;
            pagination.value.lastPage = res.data.last_page;
            pagination.value.total = res.data.total;
            pagination.value.prevPageUrl = route('wiki.monster.index', {
                page: res.data.current_page-1,
                name: form.name,
                category: form.category,
                expansion: form.expansion,
            });
            pagination.value.nextPageUrl = route('wiki.monster.index', {
                page: res.data.current_page+1,
                name: form.name,
                category: form.category,
                expansion: form.expansion,
            });
        })
        .catch(error => console.error(error));
};

search(form.data());
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-50 dark:bg-gray-800 sm:rounded w-full p-4">
                    <form
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4"
                        @submit.prevent="filter"
                    >
                        <div>
                            <InputLabel
                                for="name"
                                :value="$t('Name')"
                            />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                autofocus
                                :placeholder="$t('Name')"
                                autocomplete="name"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="category"
                                :value="$t('Category')"
                            />
                            <SelectInput
                                id="category"
                                v-model="form.category"
                                :options="$page.props.filter.category"
                                class="mt-1 block w-full"
                                :placeholder="$t('Category')"
                                autocomplete="category"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.category"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="expansion"
                                :value="$t('Expansion')"
                            />
                            <SelectInput
                                id="expansion"
                                v-model="form.expansion"
                                :options="$page.props.filter.expansion"
                                class="mt-1 block w-full"
                                :placeholder="$t('Expansion')"
                                autocomplete="expansion"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.expansion"
                            />
                        </div>

                        <div class="flex justify-end items-end">
                            <PrimaryButton
                                type="button"
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="clearAndFilter"
                            >
                                {{ $t('Clear') }}
                            </PrimaryButton>
                            <PrimaryButton
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                {{ $t('Filter') }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <p class="text-sm my-4 dark:text-white">
                    {{ monsters.length + ' ' + $t('results found.') }}
                </p>

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
                            icon
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

                    <template #pagination>
                        <Pagination
                            :items="monsters"
                            :pagination="pagination"
                        />
                    </template>
                </TableBase>
            </div>
        </div>
    </AppLayout>
</template>
