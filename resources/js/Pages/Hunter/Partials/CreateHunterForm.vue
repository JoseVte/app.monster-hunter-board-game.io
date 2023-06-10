<script setup>
import {useForm} from '@inertiajs/vue3';
import FormSection from '@/Components/Form/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';

const props = defineProps({
    campaign: Object
})

const form = useForm({
    name: '',
});

const createHunter = () => {
    form.post(route('campaigns.hunters.store', props.campaign), {
        errorBag: 'createHunter',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createHunter">
        <template #title>
            {{ $t('Hunter Details') }}
        </template>

        <template #description>
            {{ $t('description.campaign-hunter', {campaign: campaign.name}) }}
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
