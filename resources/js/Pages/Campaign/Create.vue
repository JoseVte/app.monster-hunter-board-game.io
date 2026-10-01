<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateCampaignForm from "@/Pages/Campaign/Partials/CreateCampaignForm.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";

defineProps({
    // An object, not an array: `CampaignController::create()` sends
    // `allTeams()->pluck('name', 'id')`, which serialises as `{"1": "Name"}`,
    // and `SelectInput` already types its `options` as `Record<string,
    // string>`. Declared as `Array` since this form was written, which logged
    // two "Invalid prop" warnings on every visit to the create page.
    teams: Object,
    expansions: Array,
    baseMaxDays: Number,
    defaultExpansions: Array
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
            <div class="max-w-7xl mx-auto py-6 px-4 sm:py-10 sm:px-6 lg:px-8">
                <CreateCampaignForm
                    :teams="teams"
                    :expansions="expansions"
                    :base-max-days="baseMaxDays"
                    :default-expansions="defaultExpansions"
                />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
