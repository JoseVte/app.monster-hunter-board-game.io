<script setup>
import {useForm, usePage} from '@inertiajs/vue3';
import FormSection from '@/Components/Form/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import TextareaInput from "@/Components/Form/TextareaInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import WysiwygInput from "@/Components/Form/WysiwygInput.vue";

defineProps({
    teams: Array
})

const form = useForm({
    team_id: usePage().props.auth.user.current_team.id.toString(),
    name: '',
    description: '',
    max_days: null,
});

const createCampaign = () => {
    form.post(route('campaigns.store'), {
        errorBag: 'createCampaign',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createCampaign">
        <template #title>
            {{ $t('Campaign Details') }}
        </template>

        <template #description>
            {{ $t('Create a new campaign to collaborate with others on hunters.') }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="team"
                    :value="$t('Campaign Team')"
                />
                <SelectInput
                    id="team"
                    v-model="form.team_id"
                    class="block w-full mt-1"
                    :options="teams"
                    :placeholder="$t('Campaign Team')"
                    autocomplete="team"
                />
                <InputError
                    :message="form.errors.team_id"
                    class="mt-2"
                />
            </div>

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
                <WysiwygInput
                    id="description"
                    v-model="form.description"
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
        </template>

        <template #actions>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ $t('Create') }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
