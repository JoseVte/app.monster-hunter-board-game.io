<script setup>
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/Form/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import TextareaInput from "@/Components/Form/TextareaInput.vue";

const props = defineProps({
    campaign: Object,
});

const form = useForm({
    name: props.campaign.name,
    description: props.campaign.description,
    health_potions: props.campaign.health_potions,
    max_days: props.campaign.max_days,
});

const updateCampaignDetails = () => {
    form.put(route('campaigns.update', props.campaign), {
        errorBag: 'updateCampaign',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="updateCampaignDetails">
        <template #title>
            {{ $t('Campaign Details') }}
        </template>

        <template #description>
            {{ $t('The campaign\'s detail information.') }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="name"
                    :value="$t('Name')"
                />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <InputError
                    :message="form.errors.name"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="description"
                    :value="$t('Description')"
                />
                <TextareaInput
                    id="name"
                    v-model="form.description"
                    type="text"
                    class="block w-full mt-1"
                />
                <InputError
                    :message="form.errors.description"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="max_days"
                    :value="$t('Max Days')"
                />
                <TextInput
                    id="max_days"
                    v-model="form.max_days"
                    type="number"
                    class="block w-full mt-1"
                    min="0"
                />
                <InputError
                    :message="form.errors.max_days"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="health_potions"
                    :value="$t('Health Potions')"
                />
                <TextInput
                    id="max_days"
                    v-model="form.health_potions"
                    type="number"
                    class="block w-full mt-1"
                    min="0"
                    max="3"
                />
                <InputError
                    :message="form.errors.health_potions"
                    class="mt-2"
                />
            </div>
        </template>

        <template
            #actions
        >
            <ActionMessage
                :on="form.recentlySuccessful"
                class="mr-3"
            >
                {{ $t('Saved.') }}
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ $t('Save') }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
