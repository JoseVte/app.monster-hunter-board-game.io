<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateCampaignForm from "@/Pages/Campaign/Partials/UpdateCampaignForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import ShowCampaignOwner from "@/Pages/Campaign/Partials/ShowCampaignOwner.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DeleteCampaignForm from "@/Pages/Campaign/Partials/DeleteCampaignForm.vue";

defineProps({
    campaign: Object,
});
</script>

<template>
    <AppLayout :title="$t('Edit') + ' ' + campaign.name">
        <template #header>
            <Breadcrumb
                :current-title="$t('Edit')"
                :breadcrumbs="[
                    { url: route('campaigns.show', campaign), title: campaign.name },
                ]"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ShowCampaignOwner
                    :campaign="campaign"
                />

                <SectionBorder />

                <UpdateCampaignForm
                    :campaign="campaign"
                />

                <SectionBorder />

                <DeleteCampaignForm
                    class="mt-10 sm:mt-0"
                    :campaign="campaign"
                />
            </div>
        </div>
    </AppLayout>
</template>
