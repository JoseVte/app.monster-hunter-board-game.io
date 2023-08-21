<script setup>
import _ from "lodash";
import {ref} from "vue";
import VueMultiselect from "vue-multiselect";
import {useForm, usePage} from "@inertiajs/vue3";
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
    day: Object
});

const typeDayInput = ref(props.day.monster_id ? 'MONSTER' : 'DOWNTIME');
const confirmingUpdateDay = ref(false);
const confirmUpdateDay = () => {
    confirmingUpdateDay.value = true;
};

const huntersDays = _.mapValues(
    _.keyBy(props.campaign.users, 'id'), (user) => {
        const hunter = _.find(props.day.hunters,
            (hunter) => user.membership.hunter_id === hunter.id
        )
        if (hunter) return hunter.pivot.downtime_activity_id ? hunter.pivot.downtime_activity : ''

        return '';
    }
)

const form = useForm({
    type_day: _.find(usePage().props.dayType, (option) => option.key === (props.day.monster_id ? 'MONSTER' : 'DOWNTIME')),
    all_hunters_same_activity: props.day.all_hunters_same_activity,
    day_id: props.day.downtime_activity_id ? props.day.downtime_activity : null,
    hunter_day_id: huntersDays,
    monster_id: props.day.monster_id ? props.day.monster : null,
    difficulty: props.day.difficulty ? _.find(usePage().props.monsterDifficulty, (option) => option.key === props.day.difficulty) : null,
    hunted: props.day.hunted,
});

const updateDay = () => {
    form.clearErrors();

    form.transform((data) => ({
        ...data,
        type_day: data.type_day ? data.type_day.key : null,
        day_id: data.day_id ? data.day_id.id : null,
        hunter_day_id: data.hunter_day_id ? _.mapValues(data.hunter_day_id, (day) => day.id) : huntersDays,
        monster_id: data.monster_id ? data.monster_id.id : null,
        difficulty: data.difficulty ? data.difficulty.key : null,
    })).put(route('campaigns.update-day', [props.campaign, props.day]), {
        errorBag: 'addOrUpdateCampaignDay',
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingUpdateDay.value = false;

    form.reset();
};
</script>

<template>
    <div
        class="cursor-pointer"
        @click="confirmUpdateDay"
    >
        <slot />
    </div>

    <DialogModal
        :show="confirmingUpdateDay"
        @close="closeModal"
    >
        <template #title>
            {{ $t('Update Day') }} #{{ day.number }}
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
                            :value="$t('Monster')"
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
                @click="updateDay"
            >
                {{ $t('Update Day') }}
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
