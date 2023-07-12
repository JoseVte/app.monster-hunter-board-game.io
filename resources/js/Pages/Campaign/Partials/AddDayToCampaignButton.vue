<script setup>
import _ from "lodash";
import {ref} from "vue";
import VueMultiselect from "vue-multiselect";
import {Link, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/Form/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import "vue-multiselect/dist/vue-multiselect.css";
import Checkbox from "@/Components/Form/Checkbox.vue";

const props = defineProps({
    campaign: Object,
    days: [Array, Object],
    monsters: [Array, Object],
    currentDay: {
        type: Number,
        default: 0,
    }
});
const typeDayInput = ref(null);
const confirmingAddDay = ref(false);
const confirmAddDay = () => {
    confirmingAddDay.value = true;

    setTimeout(() => typeDayInput.value.$el.focus(), 250);
};

const huntersDays = _.mapValues(_.keyBy(props.campaign.users, 'id'), () => '')

const form = useForm({
    type_day: '',
    all_hunters_same_activity: true,
    day_id: null,
    hunter_day_id: huntersDays,
    monster_id: null,
    difficulty: null,
    hunted: false,
});

const addDay = () => {
    form.clearErrors();

    form.transform((data) => ({
        ...data,
        type_day: data.type_day ? data.type_day.key : null,
        day_id: data.day_id ? data.day_id.id : null,
        hunter_day_id: data.hunter_day_id ? _.mapValues(data.hunter_day_id, (day) => day.id) : huntersDays,
        monster_id: data.monster_id ? data.monster_id.id : null,
        difficulty: data.difficulty ? data.difficulty.key : null,
    })).put(route('campaigns.add-day', [props.campaign]), {
        errorBag: 'addOrUpdateCampaignDay',
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            typeDayInput.value.$el.focus();
        }
    });
};

const closeModal = () => {
    confirmingAddDay.value = false;

    form.reset();
};
</script>

<template>
    <PrimaryButton
        class="mt-1 h-8 w-8 !p-0 inline-flex items-center justify-center !rounded-full"
        type="button"
        @click="confirmAddDay"
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
    </PrimaryButton>
    <DialogModal
        :show="confirmingAddDay"
        @close="closeModal"
    >
        <template #title>
            {{ $t('Add Day') }} #{{ currentDay }}
        </template>

        <template #content>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <InputLabel
                        for="type-day"
                        :value="$t('Type of day')"
                    />
                    <VueMultiselect
                        id="type-day"
                        ref="typeDayInput"
                        v-model="form.type_day"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm mt-1 block w-full"
                        :options="$page.props.dayType"
                        label="label"
                        track-by="key"
                        :allow-empty="false"
                        :placeholder="$t('Type of day')"
                    />

                    <InputError
                        :message="form.errors.type_day"
                        class="mt-2"
                    />
                </div>
                <template v-if="form.type_day && form.type_day.key === 'DOWNTIME'">
                    <div>
                        <InputLabel
                            class="hidden md:block"
                            for="all-hunters"
                            :value="$t('Are all the hunters do the same activity?')"
                        />
                        <label class="flex items-center pt-3">
                            <Checkbox
                                id="all-hunters"
                                v-model:checked="form.all_hunters_same_activity"
                            />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $t('Are all the hunters do the same activity?') }}</span>
                        </label>

                        <InputError
                            :message="form.errors.all_hunters_same_activity"
                            class="mt-2"
                        />
                    </div>
                    <template v-if="form.all_hunters_same_activity">
                        <div class="sm:col-span-2">
                            <InputLabel
                                for="add-day-id"
                                :value="$t('Day')"
                            />
                            <VueMultiselect
                                id="add-day-id"
                                v-model="form.day_id"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm mt-1 block w-full"
                                :options="days"
                                label="name"
                                track-by="id"
                                :allow-empty="false"
                                :placeholder="$t('Day')"
                            />

                            <InputError
                                :message="form.errors.day_id"
                                class="mt-2"
                            />
                        </div>
                        <div
                            v-if="form.day_id"
                            class="sm:col-span-2 day-description"
                            v-html="_.find(days, (day) => day.id === form.day_id.id).description"
                        />
                    </template>
                    <template
                        v-for="user in campaign.users"
                        v-else
                        :key="user.id"
                    >
                        <div>
                            <div class="dark:text-white flex flex-col gap-2">
                                <span>{{ user.name }}</span>
                                <span
                                    v-if="user.membership.hunter_id"
                                    class="text-gray-600 dark:text-gray-400 mt-2"
                                >
                                    {{ user.membership.hunter.name }}
                                </span>
                                <span
                                    v-else
                                    class="text-gray-500 mt-2"
                                >{{ $t('- Missing hunter -') }}</span>
                            </div>
                        </div>
                        <div>
                            <InputLabel
                                :for="`add-day-id-${user.id}`"
                                :value="$t('Day')"
                            />
                            <VueMultiselect
                                :id="`add-day-id-${user.id}`"
                                v-model="form.hunter_day_id[user.id]"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm mt-1 block w-full"
                                :options="days"
                                label="name"
                                track-by="id"
                                :allow-empty="false"
                                :placeholder="$t('Day')"
                            />

                            <InputError
                                v-if="_.isArray(form.errors.hunter_day_id)"
                                :message="_.find(form.errors.hunter_day_id, (day, userId) => userId === user.id)"
                                class="mt-2"
                            />

                            <InputError
                                v-else
                                :message="form.errors.hunter_day_id"
                                class="mt-2"
                            />
                        </div>
                    </template>
                </template>
                <template v-if="form.type_day && form.type_day.key === 'MONSTER'">
                    <div>
                        <InputLabel
                            for="add-monster-id"
                            :value="$t('Count')"
                        />
                        <VueMultiselect
                            id="add-monster-id"
                            v-model="form.monster_id"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm mt-1 block w-full"
                            :options="monsters"
                            label="name"
                            track-by="id"
                            :allow-empty="false"
                            :placeholder="$t('Monster')"
                        />

                        <InputError
                            :message="form.errors.monster_id"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <InputLabel
                            for="difficulty"
                            :value="$t('Difficulty')"
                        />
                        <VueMultiselect
                            id="difficulty"
                            v-model="form.difficulty"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm mt-1 block w-full"
                            :options="$page.props.monsterDifficulty"
                            label="label"
                            track-by="key"
                            :allow-empty="false"
                            :placeholder="$t('Difficulty')"
                        />

                        <InputError
                            :message="form.errors.difficulty"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <InputLabel
                            class="hidden md:block"
                            for="hunted"
                            :value="$t('Hunted?')"
                        />
                        <label class="flex items-center pt-4">
                            <Checkbox
                                id="hunted"
                                v-model:checked="form.hunted"
                            />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $t('Hunted?') }}</span>
                        </label>

                        <InputError
                            :message="form.errors.hunted"
                            class="mt-2"
                        />
                    </div>
                </template>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                {{ $t('Cancel') }}
            </SecondaryButton>

            <PrimaryButton
                id="delete-user-btn"
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="addDay"
            >
                {{ $t('Add Day') }}
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
