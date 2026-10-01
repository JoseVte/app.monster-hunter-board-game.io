<script setup>
import { useForm } from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {hasBaseGame} from '@/campaign';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/Form/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import WysiwygInput from "@/Components/Form/WysiwygInput.vue";
import CampaignTimerFields from "@/Pages/Campaign/Partials/CampaignTimerFields.vue";

const props = defineProps({
    campaign: Object,
    expansions: Array,
    baseMaxDays: Number,
});

const {t} = useI18n();

const form = useForm({
    name: props.campaign.name,
    description: props.campaign.description,
    health_potions: props.campaign.health_potions,
    // `expansions` is a nullable JSON column, so a campaign created before it
    // existed reads as null rather than as an empty list.
    expansions: props.campaign.expansions ?? [],
    max_days_automatic: props.campaign.max_days_automatic,
    max_days: props.campaign.max_days,
});


// The server refuses a campaign with no base game (`App\Rules\
// IncludesABaseGame`), and this says so without the round trip. `setError`
// writes into the same `errors.expansions` key the server's own message lands
// in, so one `InputError`, the one under the base game group, renders either.
//
// The sentence is the rule's own, character for character, on purpose: it is
// `__()`d there, which is what puts it in the lang files at all, and this
// `t()` call looks the same key up. Change one and change the other, or the
// client shows English where the server would have shown Spanish.
function missingBaseGame() {
    form.clearErrors('expansions');

    if (hasBaseGame(props.expansions, form.expansions)) {
        return false;
    }

    form.setError('expansions', t('Pick at least one of the base games.'));

    return true;
}

const updateCampaignDetails = () => {
    if (missingBaseGame()) {
        return;
    }

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

            <div class="col-span-6">
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

            <CampaignTimerFields
                v-model:selected="form.expansions"
                v-model:automatic="form.max_days_automatic"
                v-model:max-days="form.max_days"
                :expansions="expansions"
                :base-max-days="baseMaxDays"
                :errors="form.errors"
            />

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
