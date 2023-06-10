<script setup>
import {useForm, Link} from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import ActionSection from "@/Components/ActionSection.vue";
import Calendar from "@/Components/Icons/Calendar.vue";
import Potion from "@/Components/Icons/Potion.vue";
import Edit from "@/Components/Icons/Edit.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import InputError from "@/Components/Form/InputError.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import MemberManager from "@/Pages/Campaign/Partials/MemberManager.vue";
import CountForm from "@/Components/Form/CountForm.vue";

const props = defineProps({
    campaign: Object,
    availableRoles: Array,
    permissions: Object,
});

const form = useForm({
    health_potions: props.campaign.health_potions,
});

const incrementPotion = () => {
    form.health_potions++;
    form.put(route('campaigns.update-potions', props.campaign), {
        errorBag: 'updateCampaign',
        preserveScroll: true,
    });
}
const decrementPotion = () => {
    form.health_potions--;
    form.put(route('campaigns.update-potions', props.campaign), {
        errorBag: 'updateCampaign',
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout :title="campaign.name">
        <template #header>
            <Breadcrumb
                :current-title="campaign.name"
                :breadcrumbs="[]"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ActionSection>
                    <template #title>
                        {{ $t('Campaign Details') }}
                    </template>

                    <template #description>
                        {{ $t('The campaign information.') }}
                    </template>

                    <template #content>
                        <!-- Campaign Information -->
                        <div class="col-span-6 relative">
                            <div class="absolute top-0 right-0">
                                <Link :href="route('campaigns.edit', campaign)">
                                    <Edit class="h-4 w-4 text-gray-700 dark:text-gray-300" />
                                </Link>
                            </div>

                            <div
                                class="block font-medium text-gray-700 dark:text-gray-300"
                                v-text="campaign.name"
                            />

                            <div class="mt-2">
                                <p
                                    class="text-gray-600 dark:text-gray-400"
                                    v-text="campaign.description"
                                />
                            </div>

                            <div class="grid md:grid-cols-2 mt-4 w-full gap-4 border-t pt-4 border-gray-300 dark:border-gray-700">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 flex items-center justify-center">
                                        <Potion class="w-8 h-8" />
                                    </div>

                                    <div class="ml-4 leading-tight">
                                        <div class="text-gray-900 dark:text-white">
                                            {{ $t('Health Potions') }}
                                        </div>

                                        <CountForm
                                            :form="form"
                                            :decrement="decrementPotion"
                                            :increment="incrementPotion"
                                            :value="campaign.health_potions"
                                            max="3"
                                            class="w-full mt-1"
                                        />
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200 flex items-center justify-center">
                                        <Calendar class="w-8 h-8" />
                                    </div>

                                    <div class="ml-4 leading-tight">
                                        <div class="text-gray-900 dark:text-white">
                                            {{ campaign.days_count }} / {{ campaign.max_days }} {{ $t('Days') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <InputError
                                        :message="form.errors.health_potions"
                                        class="mt-2"
                                    />

                                    <ActionMessage
                                        :on="form.recentlySuccessful"
                                        class="mr-3"
                                    >
                                        {{ $t('Saved.') }}
                                    </ActionMessage>
                                </div>
                            </div>
                        </div>
                    </template>
                </ActionSection>

                <MemberManager
                    class="mt-10 sm:mt-0"
                    :campaign="campaign"
                    :available-roles="availableRoles"
                    :user-permissions="permissions"
                />
            </div>
        </div>
    </AppLayout>
</template>
