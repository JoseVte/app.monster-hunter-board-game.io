<script setup lang="ts">
// The rules of play, shown while a campaign is being set up. The text comes
// from `resources/lang/{en,es}/campaign-rules.php` through vue-i18n's `tm()`,
// not from a prop and not from the database: it is reference text, the same
// for every campaign, and nothing ever seeded it.
//
// The one thing that does arrive as a prop is the list of expansions, because
// their names live in `App\Enum\MonsterExpansion` and should be spelt in one
// place. The lang file keys its rules by the enum case's name, and this joins
// the two, so adding the rules for another expansion is a lang file edit and
// nothing else. An expansion with no rules yet is simply left out.
//
// Only the expansions in play are shown. This used to list all eight, which
// was the best it could do before a campaign recorded which ones it uses;
// now that the form above it asks, a wall of rules for boxes nobody owns is
// noise, and ticking one reveals its rules on the spot.
import {computed} from 'vue';
import {useI18n} from 'vue-i18n';

type Expansion = {key: string; label: string};

const props = defineProps<{
    expansions: Array<Expansion>;
    // `App\Enum\MonsterExpansion` case names, the same values the campaign
    // stores in its `expansions` column.
    selected: Array<string>;
}>();

// `tm()` reads a whole branch of the messages rather than one string, which is
// what a list of rules needs; `rt()` is its companion for resolving each entry,
// since an entry can reach here either as a plain string or as a compiled
// message depending on the build.
const {tm, rt} = useI18n();

function rules(path: string): Array<string> {
    const found = tm(path);

    return Array.isArray(found) ? found.map((rule) => rt(rule)) : [];
}

const downtime = computed(() => rules('campaign-rules.downtime'));

// The core rulebook's own rules, which hold whichever base game the campaign
// is played out of, so they are not keyed by expansion the way the sections
// below are. Empty today, and an empty list renders nothing.
const base = computed(() => rules('campaign-rules.base'));

const expansions = computed(() => props.expansions
    .filter((expansion) => props.selected.includes(expansion.key))
    .map((expansion) => ({
        ...expansion,
        rules: rules(`campaign-rules.expansions.${expansion.key}`),
    }))
    .filter((expansion) => expansion.rules.length > 0));
</script>

<template>
    <div v-if="downtime.length || base.length || expansions.length">
        <h3 class="mh-heading text-xs tracking-widest uppercase">
            {{ $t('Campaign Rules') }}
        </h3>

        <details
            v-if="base.length"
            class="mt-3"
        >
            <summary class="cursor-pointer text-sm font-semibold text-gray-900 dark:text-white">
                {{ $t('Base game') }}
            </summary>

            <ul class="mt-2 list-disc space-y-2 ps-5 text-sm text-gray-500 dark:text-gray-400">
                <li
                    v-for="(rule, index) in base"
                    :key="index"
                >
                    {{ rule }}
                </li>
            </ul>
        </details>

        <details
            v-if="downtime.length"
            class="mt-3"
        >
            <summary class="cursor-pointer text-sm font-semibold text-gray-900 dark:text-white">
                {{ $t('Downtime') }}
            </summary>

            <ul class="mt-2 list-disc space-y-2 ps-5 text-sm text-gray-500 dark:text-gray-400">
                <li
                    v-for="(rule, index) in downtime"
                    :key="index"
                >
                    {{ rule }}
                </li>
            </ul>
        </details>

        <details
            v-for="expansion in expansions"
            :key="expansion.key"
            class="mt-3"
        >
            <summary class="cursor-pointer text-sm font-semibold text-gray-900 dark:text-white">
                {{ expansion.label }}
            </summary>

            <ul class="mt-2 list-disc space-y-2 ps-5 text-sm text-gray-500 dark:text-gray-400">
                <li
                    v-for="(rule, index) in expansion.rules"
                    :key="index"
                >
                    {{ rule }}
                </li>
            </ul>
        </details>
    </div>
</template>
