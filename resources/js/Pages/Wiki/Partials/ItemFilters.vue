<script setup>
import {computed, ref, watch} from "vue";
import {useI18n} from "vue-i18n";
import {router} from "@inertiajs/vue3";
import _ from "lodash";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

// Name and type. Unlike weapons and armours an item has no rarity or
// expansion, so this is its own filter bar rather than WikiFilters with
// unused fields.
const props = defineProps({
    filters: Object,
    options: Object,
});

const emit = defineEmits(['loading']);

const {t} = useI18n();

const query = ref(props.filters.q ?? '');
const type = ref(props.filters.type ?? '');

const send = () => {
    router.get(route('wiki.item.index'), {
        q: query.value || undefined,
        type: type.value || undefined,
        // Neither field here, so changing them should not reset it.
        sort: props.filters.sort,
        direction: props.filters.direction,
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['items', 'filters'],
        onStart: () => emit('loading', true),
        onFinish: () => emit('loading', false),
    });
};

// Typing sends on a pause rather than on every key, so a long name is one
// request and not fifteen.
const sendSoon = _.debounce(send, 350);

watch(query, sendSoon);
watch(type, send);

const clear = () => {
    query.value = '';
    type.value = '';
};

const anyFilter = () => query.value || type.value;

const typeOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.types.map((option) => [option.key, option.label])),
}));
</script>

<template>
    <div class="mh-frame bg-white p-4 dark:bg-gray-800">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-[2fr_1fr_auto] sm:items-end">
            <div>
                <InputLabel
                    for="item-q"
                    :value="$t('Name')"
                />
                <TextInput
                    id="item-q"
                    v-model="query"
                    type="search"
                    class="mt-1 block w-full"
                    :placeholder="$t('Name')"
                />
            </div>

            <div>
                <InputLabel
                    for="item-type"
                    :value="$t('Type')"
                />
                <SelectInput
                    id="item-type"
                    v-model="type"
                    class="mt-1 block w-full"
                    :options="typeOptions"
                />
            </div>

            <SecondaryButton
                class="justify-center"
                :disabled="!anyFilter()"
                @click="clear"
            >
                {{ $t('Clear') }}
            </SecondaryButton>
        </div>
    </div>
</template>
