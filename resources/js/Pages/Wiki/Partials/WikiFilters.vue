<script setup>
import {computed, ref, watch} from "vue";
import {useI18n} from "vue-i18n";
import {router} from "@inertiajs/vue3";
import _ from "lodash";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

// Name, rarity and box. The name is searched in both languages, since a piece
// is as often known by its English name as by its Spanish one.
const props = defineProps({
    filters: Object,
    options: Object,
    routeName: String,
    routeParams: {
        type: Array,
        default: () => [],
    },
    // Everything the page shows below the filters is a prop somewhere; naming
    // the ones the result actually needs is what turns the request from a full
    // page visit into a partial one.
    only: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['loading']);

const {t} = useI18n();

const query = ref(props.filters.q ?? '');
const rarity = ref(props.filters.rarity ?? '');
const expansion = ref(props.filters.expansion ?? '');

const send = () => {
    router.get(route(props.routeName, props.routeParams), {
        q: query.value || undefined,
        rarity: rarity.value || undefined,
        expansion: expansion.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: props.only,
        onStart: () => emit('loading', true),
        onFinish: () => emit('loading', false),
    });
};

// Typing sends on a pause rather than on every key, so a long name is one
// request and not fifteen.
const sendSoon = _.debounce(send, 350);

watch(query, sendSoon);
watch([rarity, expansion], send);

const clear = () => {
    query.value = '';
    rarity.value = '';
    expansion.value = '';
};

const anyFilter = () => query.value || rarity.value || expansion.value;

// SelectInput reads its options as value to label, and its placeholder option is
// disabled, so Any is a real option or a filter could never be cleared from the
// select itself.
const rarityOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.rarities.map((value) => [value, value])),
}));

const expansionOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.expansions.map((option) => [option.key, option.label])),
}));
</script>

<template>
    <div class="mh-frame bg-white p-4 dark:bg-gray-800">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-[2fr_1fr_1.5fr_auto] sm:items-end">
            <div>
                <InputLabel
                    for="wiki-q"
                    :value="$t('Name')"
                />
                <TextInput
                    id="wiki-q"
                    v-model="query"
                    type="search"
                    class="mt-1 block w-full"
                    :placeholder="$t('Name')"
                />
            </div>

            <div>
                <InputLabel
                    for="wiki-rarity"
                    :value="$t('Rarity')"
                />
                <SelectInput
                    id="wiki-rarity"
                    v-model="rarity"
                    class="mt-1 block w-full"
                    :options="rarityOptions"
                />
            </div>

            <div>
                <InputLabel
                    for="wiki-expansion"
                    :value="$t('Expansion')"
                />
                <SelectInput
                    id="wiki-expansion"
                    v-model="expansion"
                    class="mt-1 block w-full"
                    :options="expansionOptions"
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
