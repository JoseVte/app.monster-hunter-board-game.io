<script setup>
import {useForm, Link} from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import ActionSection from "@/Components/ActionSection.vue";
import Calendar from "@/Components/Icons/Calendar.vue";
import Potion from "@/Components/Icons/Potion.vue";
import Edit from "@/Components/Icons/Edit.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import InputError from "@/Components/Form/InputError.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import TeamMemberManager from "@/Pages/Teams/Partials/TeamMemberManager.vue";
import MemberManager from "@/Pages/Campaign/Partials/MemberManager.vue";

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

                                        <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                            <button
                                                type="button"
                                                class="bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 flex items-center justify-center h-full w-10 rounded-l cursor-pointer outline-none"
                                                :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing"
                                                @click="decrementPotion"
                                            >
                                                <svg
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M18 12H6"
                                                    />
                                                </svg>
                                            </button>
                                            <div
                                                class="outline-none px-2 w-auto border-0 focus:outline-none text-center bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 font-semibold text-md flex items-center"
                                            >
                                                {{ campaign.health_potions }} / 3
                                            </div>
                                            <button
                                                type="button"
                                                class="bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 flex items-center justify-center h-full w-10 rounded-r cursor-pointer outline-none"
                                                :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing"
                                                @click="incrementPotion"
                                            >
                                                <svg
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M12 6v12m6-6H6"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
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
