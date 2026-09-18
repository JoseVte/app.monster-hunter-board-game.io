<script setup>
import {computed, ref, watch} from "vue";
import {useI18n} from "vue-i18n";
import {router} from "@inertiajs/vue3";
import _ from "lodash";
import TextInput from "@/Components/Form/TextInput.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

// Name, category and expansion. Its own filter bar rather than WikiFilters,
// which asks for a rarity a monster does not have.
const props = defineProps({
    filters: Object,
    options: Object,
});

const emit = defineEmits(['loading']);

const {t} = useI18n();

const query = ref(props.filters.q ?? '');
const category = ref(props.filters.category ?? '');
const expansion = ref(props.filters.expansion ?? '');

const send = () => {
    router.get(route('wiki.monster.index'), {
        q: query.value || undefined,
        category: category.value || undefined,
        expansion: expansion.value || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['monsters', 'filters'],
        onStart: () => emit('loading', true),
        onFinish: () => emit('loading', false),
    });
};

// Typing sends on a pause rather than on every key, so a long name is one
// request and not fifteen.
const sendSoon = _.debounce(send, 350);

watch(query, sendSoon);
watch([category, expansion], send);

const clear = () => {
    query.value = '';
    category.value = '';
    expansion.value = '';
};

const anyFilter = () => query.value || category.value || expansion.value;

const categoryOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.categories.map((option) => [option.key, option.label])),
}));

const expansionOptions = computed(() => ({
    '': t('Any'),
    ...Object.fromEntries(props.options.expansions.map((option) => [option.key, option.label])),
}));
</script>

<template>
    <div class="mh-frame bg-white p-4 dark:bg-gray-800">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-[2fr_1fr_1.5fr_auto]">
            <div>
                <InputLabel
                    for="monster-q"
                    :value="$t('Name')"
                />
                <TextInput
                    id="monster-q"
                    v-model="query"
                    type="search"
                    class="mt-1 block w-full"
                    :placeholder="$t('Name')"
                />
            </div>

            <div>
                <InputLabel
                    for="monster-category"
                    :value="$t('Category')"
                />
                <SelectInput
                    id="monster-category"
                    v-model="category"
                    class="mt-1 block w-full"
                    :options="categoryOptions"
                />
            </div>

            <div>
                <InputLabel
                    for="monster-expansion"
                    :value="$t('Expansion')"
                />
                <SelectInput
                    id="monster-expansion"
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
