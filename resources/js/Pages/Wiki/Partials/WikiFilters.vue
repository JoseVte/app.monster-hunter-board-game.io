<script setup lang="ts">
import {computed, ref, watch} from "vue";
import {useI18n} from "vue-i18n";
import {router} from "@inertiajs/vue3";
import _ from "lodash";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

// Shared by `WeaponController` and `ArmorController`'s own private `filters()`
// and `options()` methods; no model backs either shape.
type WikiFilterValues = {
    q: string | null;
    rarity: number | null;
    expansion: string | null;
    branch: string | null;
};

type WikiFilterOptions = {
    rarities: number[];
    expansions: Array<{key: string; label: string}>;
    branches: Array<{key: string; label: string}>;
};

// Name, rarity and box. The name is searched in both languages, since a piece
// is as often known by its English name as by its Spanish one.
const props = withDefaults(defineProps<{
    filters: WikiFilterValues;
    options: WikiFilterOptions;
    // Ziggy's `route()` only accepts a known route name (see `ziggy-global.d.ts`),
    // so this stays that same type rather than a plain `string`: every caller
    // passes a real route name, and a typo here should fail to compile too.
    routeName: keyof import('ziggy-js').RouteList;
    routeParams?: Array<string | number>;
    // Everything the page shows below the filters is a prop somewhere; naming
    // the ones the result actually needs is what turns the request from a full
    // page visit into a partial one.
    only?: string[];
}>(), {
    routeParams: () => [],
    only: () => [],
});

const emit = defineEmits(['loading']);

const {t} = useI18n();

const query = ref(props.filters.q ?? '');
// `SelectInput.vue` declares `modelValue: string`, so a numeric filter value
// is coerced up front rather than handed through as `number | string`.
const rarity = ref(String(props.filters.rarity ?? ''));
const expansion = ref(props.filters.expansion ?? '');
const branch = ref(props.filters.branch ?? '');

const send = () => {
    router.get(route(props.routeName, props.routeParams), {
        q: query.value || undefined,
        rarity: rarity.value || undefined,
        expansion: expansion.value || undefined,
        branch: branch.value || undefined,
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
watch([rarity, expansion, branch], send);

const clear = () => {
    query.value = '';
    rarity.value = '';
    expansion.value = '';
    branch.value = '';
};

const anyFilter = () => query.value || rarity.value || expansion.value || branch.value;

// SelectInput reads its options as value to label, and its placeholder option is
// disabled, so Any is a real option or a filter could never be cleared from the
// select itself.
const rarityOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.rarities.map((value) => [value, String(value)])),
}));

const expansionOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.expansions.map((option) => [option.key, option.label])),
}));

const branchOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.branches.map((option) => [option.key, option.label])),
}));
</script>

<template>
    <div class="mh-frame bg-white p-4 dark:bg-gray-800">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-[1.6fr_0.7fr_1fr_1fr_auto]">
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
                    for="wiki-branch"
                    :value="$t('Monster')"
                />
                <SelectInput
                    id="wiki-branch"
                    v-model="branch"
                    class="mt-1 block w-full"
                    :options="branchOptions"
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

            <!-- The invisible label matches the real labels' height so the
                 button's own box, stretched to fill what is left, comes out
                 exactly as tall as the fields beside it. -->
            <div class="flex flex-col">
                <InputLabel
                    value="Clear"
                    class="invisible"
                />
                <SecondaryButton
                    class="mt-1 w-full flex-1 justify-center"
                    :disabled="!anyFilter()"
                    @click="clear"
                >
                    {{ $t('Clear') }}
                </SecondaryButton>
            </div>
        </div>
    </div>
</template>
