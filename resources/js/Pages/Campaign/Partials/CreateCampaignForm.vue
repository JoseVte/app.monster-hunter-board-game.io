<script setup>
import {useForm, usePage} from '@inertiajs/vue3';
import {useI18n} from 'vue-i18n';
import {hasBaseGame} from '@/campaign';
import FormSection from '@/Components/Form/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import SelectInput from "@/Components/Form/SelectInput.vue";
import WysiwygInput from "@/Components/Form/WysiwygInput.vue";
import CampaignTimerFields from "@/Pages/Campaign/Partials/CampaignTimerFields.vue";

const props = defineProps({
    // An object, not an array: `CampaignController::create()` sends
    // `allTeams()->pluck('name', 'id')`, which serialises as `{"1": "Name"}`,
    // and `SelectInput` already types its `options` as `Record<string,
    // string>`. Declared as `Array` since this form was written, which logged
    // two "Invalid prop" warnings on every visit to the create page.
    teams: Object,
    expansions: Array,
    baseMaxDays: Number,
    // The boxes a new campaign starts out ticked with, named by
    // `MonsterExpansion::defaultCampaignBox()` rather than here. Defaulted so
    // that a page which forgets to forward it opens with nothing ticked and
    // says so on submit, rather than throwing on mount.
    defaultExpansions: {type: Array, default: () => []}
})

const {t} = useI18n();

const form = useForm({
    team_id: usePage().props.auth.user.current_team.id.toString(),
    name: '',
    description: '',
    // A new campaign works its timer out from the expansions by default; the
    // switch in CampaignTimerFields is what hands the number back over.
    expansions: [...props.defaultExpansions],
    max_days_automatic: true,
    max_days: 0,
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

const createCampaign = () => {
    if (missingBaseGame()) {
        return;
    }

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

            <CampaignTimerFields
                v-model:selected="form.expansions"
                v-model:automatic="form.max_days_automatic"
                v-model:max-days="form.max_days"
                :expansions="expansions"
                :base-max-days="baseMaxDays"
                :errors="form.errors"
            />
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
