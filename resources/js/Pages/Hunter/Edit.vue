<script setup>
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateHunterForm from "@/Pages/Hunter/Partials/UpdateHunterForm.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";

defineProps({
    campaign: Object,
    hunter: Object,
});
</script>

<template>
    <AppLayout :title="$t('Edit') + ' ' + hunter.name">
        <template #header>
            <Breadcrumb
                :current-title="$t('Edit')"
                :breadcrumbs="[
                    { url: route('campaigns.show', campaign), title: campaign.name },
                    { url: route('campaigns.hunters.show', [campaign, hunter]), title: hunter.name, icon: WeaponsIcon },
                ]"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateHunterForm
                    :campaign="campaign"
                    :hunter="hunter"
                />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
