<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Card from "@/Components/Card.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
import WikiFilters from "@/Pages/Wiki/Partials/WikiFilters.vue";

defineProps({
    weaponTypes: [Array, Object],
    filters: Object,
    options: Object,
});

const loading = ref(false);
</script>

<template>
    <AppLayout :title="$t('Weapons')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Weapons')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="WeaponsIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <WikiFilters
                    :filters="filters"
                    :options="options"
                    route-name="wiki.weapon.index"
                    :only="['weaponTypes', 'filters']"
                    @loading="loading = $event"
                />

                <!-- A type with nothing to show says so rather than opening on an
                     empty tree. -->
                <LoadingOverlay :loading="loading">
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <Card
                            v-for="weaponType in weaponTypes"
                            :key="weaponType.id"
                            class="gap-2"
                            :class="{ 'opacity-45': !weaponType.weapons_count }"
                        >
                            <Link
                                :href="route('wiki.weapon.type', [weaponType, filters])"
                                class="flex cursor-pointer items-center gap-3 text-left"
                            >
                                <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                                    <img
                                        class="h-6 w-6 drop-shadow-sm"
                                        :src="weaponType.image_url"
                                        :alt="weaponType.name"
                                    >
                                </span>
                                <span class="mh-card-name flex-1 text-base">{{ weaponType.name }}</span>
                            </Link>

                            <div class="mh-rule" />

                            <div class="flex flex-wrap items-baseline gap-x-2 text-sm text-gray-600 dark:text-gray-400">
                                <span class="mh-value">{{ weaponType.weapons_count }}</span>
                                <span>{{ $t('weapons') }}</span>
                            </div>
                        </Card>
                    </div>
                </LoadingOverlay>
            </div>
        </div>
    </AppLayout>
</template>
