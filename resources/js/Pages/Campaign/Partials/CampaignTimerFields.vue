<script setup lang="ts">
// The expansions in play, the campaign timer they add up to, and the rules
// that come with them. Shared by the create and the edit form rather than
// written twice: the two differ only in where the starting values come from,
// and a timer that computed itself differently on the two screens is exactly
// the bug this being one component prevents.
import {computed, watch} from 'vue';
import Checkbox from '@/Components/Form/Checkbox.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import Switch from '@/Components/Form/Switch.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import CampaignRules from '@/Pages/Campaign/Partials/CampaignRules.vue';

type Expansion = {key: string; label: string; base_game: boolean; extra_days: number};

const props = defineProps<{
    // `App\Enum\MonsterExpansion::asCampaignOptions()`, in the enum's own order.
    expansions: Array<Expansion>;
    // `Campaign::BASE_MAX_DAYS`, the timer before any expansion lengthens it.
    baseMaxDays: number;
    // The form's own error bag, passed down rather than re-derived: the keys
    // are the request's (`expansions`, `max_days`), not this component's.
    errors: Record<string, string | undefined>;
}>();

const selected = defineModel<Array<string>>('selected', {required: true});
const automatic = defineModel<boolean>('automatic', {required: true});
const maxDays = defineModel<number | string>('maxDays', {required: true});

// Split rather than one flat list, because the two answer different questions:
// which box the campaign is played out of (at least one, `IncludesABaseGame`
// refuses a set without one) and what has been added to it.
const baseGames = computed(() => props.expansions.filter((expansion) => expansion.base_game));
const addOns = computed(() => props.expansions.filter((expansion) => ! expansion.base_game));

const suggested = computed(() => props.baseMaxDays + props.expansions
    .filter((expansion) => selected.value.includes(expansion.key))
    .reduce((total, expansion) => total + expansion.extra_days, 0));

// On automatic the field is a preview of what the server is about to store,
// not the thing that decides it: `Campaign::booted()` recomputes the column on
// every save, so a hand-edited number could never reach the database anyway.
// Keeping the two in step here is only so the form does not show one figure
// while saving another.
//
// `immediate` matters on the edit form: a campaign already on automatic whose
// expansions were changed elsewhere would otherwise open showing the stored
// number until the first tick.
watch([suggested, automatic], ([days, isAutomatic]) => {
    if (isAutomatic) {
        maxDays.value = days;
    }
}, {immediate: true});
</script>

<template>
    <div class="col-span-6 sm:col-span-4">
        <InputLabel :value="$t('Base game')" />

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $t('A campaign is played out of one of these, or both. Pick at least one.') }}
        </p>

        <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-2">
            <label
                v-for="box in baseGames"
                :key="box.key"
                class="flex items-center"
            >
                <Checkbox
                    v-model:checked="selected"
                    :value="box.key"
                />
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ box.label }}
                    <span
                        v-if="box.extra_days"
                        class="text-gray-500"
                    >(+{{ box.extra_days }} {{ $t('days') }})</span>
                </span>
            </label>
        </div>

        <InputError
            :message="errors.expansions"
            class="mt-2"
        />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel :value="$t('Expansions')" />

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $t('Which boxes are in play. Their rules and extra days are added to the campaign.') }}
        </p>

        <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-2">
            <label
                v-for="expansion in addOns"
                :key="expansion.key"
                class="flex items-center"
            >
                <Checkbox
                    v-model:checked="selected"
                    :value="expansion.key"
                />
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ expansion.label }}
                    <span
                        v-if="expansion.extra_days"
                        class="text-gray-500"
                    >(+{{ expansion.extra_days }} {{ $t('days') }})</span>
                </span>
            </label>
        </div>
    </div>

    <div class="col-span-6 sm:col-span-4">
        <InputLabel
            for="max_days"
            :value="$t('Max Days')"
        />

        <Switch
            v-model:checked="automatic"
            class="mt-2"
            :label="$t('Work the timer out from the expansions')"
        />

        <TextInput
            id="max_days"
            v-model="maxDays"
            type="number"
            class="block w-full mt-2"
            min="0"
            :disabled="automatic"
        />

        <!-- Shown on manual too, which is the point: turning the switch off is
             for overriding the number, not for losing sight of it. -->
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ $t('Suggested') }}: {{ suggested }} {{ $t('days') }}
        </p>

        <InputError
            :message="errors.max_days"
            class="mt-2"
        />
    </div>

    <div class="col-span-6 sm:col-span-4">
        <CampaignRules
            :expansions="expansions"
            :selected="selected"
        />
    </div>
</template>
