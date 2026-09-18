<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
import Card from "@/Components/Card.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
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

                <LoadingOverlay :loading="loading">
                    <p
                        v-if="!monsters.length"
                        class="mt-6 text-sm text-gray-600 dark:text-parchment-dim"
                    >
                        {{ $t('Nothing matches those filters.') }}
                    </p>

                    <div
                        v-else
                        class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <Link
                            v-for="monster in monsters"
                            :key="monster.id"
                            :href="route('wiki.monster.show', [monster.id])"
                        >
                            <Card
                                clickable
                                class="gap-2"
                            >
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center overflow-hidden rounded-full bg-gray-300 dark:bg-gray-900">
                                        <img
                                            :src="monster.icon_url"
                                            :alt="monster.name"
                                            class="h-8 w-8 object-contain"
                                        >
                                    </span>
                                    <span class="mh-card-name flex-1 text-base">{{ monster.name }}</span>
                                </div>

                                <div class="mh-rule" />

                                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="mh-value">{{ monster.category }}</span>
                                    <span class="mh-value">{{ monster.expansion }}</span>
                                </div>
                            </Card>
                        </Link>
                    </div>
                </LoadingOverlay>
            </div>
        </div>
    </AppLayout>
</template>
