<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateCampaignForm from "@/Pages/Campaign/Partials/CreateCampaignForm.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";

defineProps({
    teams: Array
})
</script>

<template>
    <AppLayout :title="$t('Create Campaign')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Create Campaign')"
                :breadcrumbs="[]"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateCampaignForm :teams="teams" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
