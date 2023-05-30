<script setup>
import {Link} from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import Dashboard from "@/Components/Icons/Dashboard.vue";
import ListCampaigns from "@/Pages/Campaign/Partials/ListCampaigns.vue";

defineProps({
    campaigns: Array
})
</script>

<template>
    <AppLayout :title="$t('Dashboard')">
        <template #header>
            <Link
                :href="route('dashboard')"
                class="flex items-center gap-4 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
            >
                <Dashboard class="w-4 h-4" />
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $t('Dashboard') }}
                </h2>
            </Link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ListCampaigns :campaigns="campaigns" />
            </div>
        </div>
    </AppLayout>
</template>
