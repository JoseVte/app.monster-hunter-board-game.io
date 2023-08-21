<script setup>

import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import _ from "lodash";
import VueMultiselect from "vue-multiselect";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/Form/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import "vue-multiselect/dist/vue-multiselect.css";

const props = defineProps({
    campaign: Object,
    hunter: Object,
    items: [Array, Object],
    label: {
        type: String,
        default: () => this.$t('Add Item'),
    },
    labelBtn: {
        type: String,
        default: () => this.$t('Add Item'),
    }
});
const itemInput = ref(null);
const countInput = ref(null);

const confirmingAddItem = ref(false);
const confirmAddItem = () => {
    confirmingAddItem.value = true;

    setTimeout(() => itemInput.value.$el.focus(), 250);
};

const form = useForm({
    item_id: '',
    count_item: 0,
});

const countItemHunter = (itemId) => {
    const hunterItemCount = _.find(props.hunter.items, (hunterItem) => {
        return itemId === hunterItem.pivot.item_id
    });
    if (hunterItemCount) {
        return hunterItemCount.pivot.number;
    }

    return 0;
}

const onChangeItemId = (item) => {
    const count = countItemHunter(item.id);
    countInput.value = count;
    form.count_item = count;
};

const addItem = () => {
    form.put(route('campaigns.hunters.items.update-count', [props.campaign, props.hunter, form.item_id]), {
        errorBag: 'updateHunterItem',
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            itemInput.value.focus();
            countInput.value.focus();
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingAddItem.value = false;

    form.reset();
};
</script>

<template>
    <PrimaryButton @click="confirmAddItem">
        {{ labelBtn }}
    </PrimaryButton>
    <DialogModal
        :show="confirmingAddItem"
        @close="closeModal"
    >
        <template #title>
            {{ label }}
        </template>

        <template #content>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <InputLabel
                        for="add-item-id"
                        :value="$t('Item')"
                    />
                    <VueMultiselect
                        id="add-item-id"
                        ref="itemInput"
                        v-model="form.item_id"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm mt-1 block w-full"
                        :options="items"
                        label="name"
                        track-by="id"
                        :allow-empty="false"
                        :placeholder="$t('Item')"
                        @input="onChangeItemId"
                        @select="onChangeItemId"
                    />

                    <InputError
                        :message="form.errors.item_id"
                        class="mt-2"
                    />
                </div>
                <div>
                    <InputLabel
                        for="add-item-count"
                        :value="$t('Count')"
                    />
                    <TextInput
                        id="add-item-count"
                        ref="countInput"
                        v-model="form.count_item"
                        type="number"
                        min="0"
                        class="mt-1 block w-full"
                        :placeholder="$t('Count')"
                    />

                    <InputError
                        :message="form.errors.count_item"
                        class="mt-2"
                    />
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                {{ $t('Cancel') }}
            </SecondaryButton>

            <PrimaryButton
                id="add-item-btn"
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="addItem"
            >
                {{ labelBtn }}
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
