<script setup>
import {computed, ref} from "vue";
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
    // Either a flat list, or a list of { monster, items } the picker heads.
    items: [Array, Object],
    grouped: Boolean,
    label: String,
    labelBtn: String,
});

const itemInput = ref(null);

const confirmingAddItem = ref(false);
const confirmAddItem = () => {
    confirmingAddItem.value = true;

    setTimeout(() => itemInput.value?.$el?.focus(), 250);
};

// What the hunter already holds of a part, which is what the count starts at
// since a count replaces rather than adds.
const heldCount = (itemId) => _.find(
    props.hunter.items,
    (held) => itemId === held.pivot.item_id,
)?.pivot?.number ?? 0;

const picked = ref(null);
const count = ref(0);

const onPick = (item) => {
    count.value = heldCount(item.id);
};

// A hunt yields a handful of parts, so they are gathered here and sent together
// rather than one modal at a time.
const staged = ref([]);

const stage = () => {
    if (! picked.value) return;

    const already = staged.value.findIndex((entry) => entry.item.id === picked.value.id);
    const entry = { item: picked.value, number: Number(count.value) || 0 };

    if (already === -1) {
        staged.value.push(entry);
    } else {
        staged.value[already] = entry;
    }

    picked.value = null;
    count.value = 0;
};

const unstage = (index) => staged.value.splice(index, 1);

const form = useForm({ items: [] });

const save = () => {
    form.items = staged.value.map((entry) => ({ item_id: entry.item.id, number: entry.number }));

    form.put(route('campaigns.hunters.items.store-many', [props.campaign, props.hunter]), {
        errorBag: 'storeHunterItems',
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingAddItem.value = false;
    staged.value = [];
    picked.value = null;
    count.value = 0;
    form.reset();
    form.clearErrors();
};

const canSave = computed(() => staged.value.length > 0 && ! form.processing);
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
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-[2fr_1fr_auto] sm:items-end">
                <div>
                    <InputLabel
                        for="add-item-id"
                        :value="$t('Item')"
                    />
                    <VueMultiselect
                        id="add-item-id"
                        ref="itemInput"
                        v-model="picked"
                        class="mt-1 block w-full"
                        :options="items"
                        :group-values="grouped ? 'items' : null"
                        :group-label="grouped ? 'monster' : null"
                        :group-select="false"
                        label="name"
                        track-by="id"
                        :placeholder="$t('Item')"
                        @select="onPick"
                    />
                </div>
                <div>
                    <InputLabel
                        for="add-item-count"
                        :value="$t('Count')"
                    />
                    <TextInput
                        id="add-item-count"
                        v-model="count"
                        type="number"
                        min="0"
                        class="mt-1 block w-full"
                        :placeholder="$t('Count')"
                    />
                </div>
                <SecondaryButton
                    class="justify-center"
                    :disabled="!picked"
                    @click="stage"
                >
                    {{ $t('Add to list') }}
                </SecondaryButton>
            </div>

            <InputError
                :message="form.errors.items"
                class="mt-2"
            />

            <!-- What will be saved. Nothing is written until the list is
                 confirmed, so a mistake can be taken back out. -->
            <div class="mt-4">
                <h4 class="mh-heading text-xs tracking-widest uppercase">
                    {{ $t('To add') }}
                </h4>

                <p
                    v-if="!staged.length"
                    class="mt-2 text-sm text-gray-600 dark:text-parchment-dim"
                >
                    {{ $t('Nothing on the list yet.') }}
                </p>

                <ul
                    v-else
                    class="mt-2 flex flex-col gap-1"
                >
                    <li
                        v-for="(entry, index) in staged"
                        :key="entry.item.id"
                        class="flex items-center justify-between gap-3 text-sm"
                    >
                        <span class="text-gray-900 dark:text-parchment">{{ entry.item.name }}</span>
                        <span class="flex items-center gap-3">
                            <span class="mh-value">{{ entry.number }}</span>
                            <button
                                type="button"
                                class="cursor-pointer text-sm text-red-500"
                                @click="unstage(index)"
                            >
                                {{ $t('Remove') }}
                            </button>
                        </span>
                    </li>
                </ul>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                {{ $t('Cancel') }}
            </SecondaryButton>

            <PrimaryButton
                id="add-item-btn"
                :class="{ 'opacity-25': !canSave }"
                :disabled="!canSave"
                @click="save"
            >
                {{ labelBtn }}
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
