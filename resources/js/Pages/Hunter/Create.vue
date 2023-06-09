<script setup>
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateHunterForm from "@/Pages/Hunter/Partials/CreateHunterForm.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";

defineProps({
    campaign: Object,
});
</script>

<template>
    <AppLayout :title="$t('Create Your Hunter')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Create Your Hunter')"
                :breadcrumbs="[
                    { url: route('campaigns.show', campaign), title: campaign.name },
                ]"
                :icon="WeaponsIcon"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateHunterForm :campaign="campaign" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
