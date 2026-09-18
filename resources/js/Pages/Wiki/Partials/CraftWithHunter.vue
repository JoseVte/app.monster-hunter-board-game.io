<script setup>
import {computed, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Tooltip from "@/Components/Tooltip.vue";
import Check from "@/Components/Icons/Check.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";

// Craft what the card describes with one of the reader's own hunters. Which of
// them can pay for it comes from the server, so the answer here is the same one
// the endpoint will give.
const props = defineProps({
    hunters: {
        type: Array,
        default: () => [],
    },
    weapon: Object,
    armor: Object,
});

const options = computed(() => Object.fromEntries(
    props.hunters.map((hunter) => [hunter.id, `${hunter.name} · ${hunter.campaign}`]),
));

// SelectInput's native <select> only ever emits strings back, so the default
// has to start as one too or Vue flags the very first render as the wrong type.
const chosenId = ref(String(props.hunters[0]?.id ?? ''));
const chosen = computed(() => props.hunters.find((hunter) => String(hunter.id) === String(chosenId.value)));

// A weapon can have two recipes, and the hunter picks which parts to spend.
const recipeId = ref(null);
const recipes = computed(() => props.weapon?.recipes ?? []);
const affordable = (recipe) => chosen.value?.craftable_recipes?.includes(recipe.id) ?? false;

// What is missing is asked for the recipe the player is looking at: the one
// picked, or the first when a weapon has only the one.
const missingItems = computed(() => {
    if (props.weapon) {
        const id = recipeId.value ?? recipes.value[0]?.id ?? null;

        return chosen.value?.missing_by_recipe?.[id] ?? [];
    }

    return chosen.value?.missing ?? [];
});

// An upgrade needs the weapon it builds on already in hand, before the parts
// are even a question, so a gap here is worth its own line in the tooltip.
const requiresParent = computed(() => !! (props.weapon?.parent && chosen.value && ! chosen.value.parent_owned));

const hasTooltipContent = computed(() => requiresParent.value || missingItems.value.length > 0);

const form = useForm({recipe: null});

const craft = () => {
    if (! chosen.value) return;

    const target = props.weapon
        ? route('campaigns.hunters.weapons.craft', [chosen.value.campaign_id, chosen.value.id, props.weapon.type_id, props.weapon.id])
        : route('campaigns.hunters.armors.craft', [chosen.value.campaign_id, chosen.value.id, props.armor.id]);

    form.recipe = props.weapon ? (recipeId.value ?? chosen.value.craftable_recipes?.[0] ?? null) : null;
    form.post(target, {preserveScroll: true});
};
</script>

<template>
    <!-- A starting piece is never crafted, so there is nothing here for it to
         say. -->
    <Card
        v-if="! (weapon?.is_default || armor?.is_default)"
        class="mt-4 gap-3 p-5"
    >
        <h3 class="mh-heading text-xs tracking-widest uppercase">
            {{ $t('Craft') }}
        </h3>

        <p
            v-if="!hunters.length"
            class="text-sm text-gray-600 dark:text-parchment-dim"
        >
            {{ $t('You have no hunters yet.') }}
        </p>

        <template v-else>
            <div>
                <InputLabel
                    for="craft-hunter"
                    :value="$t('Hunter')"
                />
                <SelectInput
                    id="craft-hunter"
                    v-model="chosenId"
                    class="mt-1 block w-full"
                    :options="options"
                />
            </div>

            <p
                v-if="chosen?.owned"
                class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-parchment-dim"
            >
                <Check class="h-4 w-4 shrink-0 text-primary-500" />
                {{ $t('This hunter already has it.') }}
            </p>

            <!-- Armour has no upgrade tree the way a weapon does, so a second
                 copy buys nothing and there is no point offering it. A weapon
                 can still be built again on top of what is already owned. -->
            <template v-if="!armor || !chosen?.owned">
                <!-- Two dual blades can be built from either of two monsters, at
                     different prices, so the choice of parts is the player's. -->
                <div
                    v-if="recipes.length > 1"
                    class="flex flex-col gap-2"
                >
                    <label
                        v-for="recipe in recipes"
                        :key="recipe.id"
                        class="flex cursor-pointer items-center gap-2 text-sm"
                        :class="{ 'opacity-45': !affordable(recipe) }"
                    >
                        <input
                            v-model="recipeId"
                            type="radio"
                            class="mh-checkbox"
                            :value="recipe.id"
                            :disabled="!affordable(recipe)"
                        >
                        <span>{{ recipe.branch }}</span>
                    </label>
                </div>

                <Tooltip :disabled="chosen?.can_craft || ! hasTooltipContent">
                    <SecondaryButton
                        class="w-full justify-center"
                        :class="{ 'opacity-25': !chosen?.can_craft || form.processing }"
                        :disabled="!chosen?.can_craft || form.processing"
                        @click="craft"
                    >
                        {{ chosen?.can_craft ? $t('Craft') : $t('Not enough materials') }}
                    </SecondaryButton>

                    <template #content>
                        <p
                            v-if="requiresParent"
                            class="mb-1"
                        >
                            {{ $t('Requires') }}: <span class="font-semibold">{{ weapon.parent.name }}</span>
                        </p>

                        <template v-if="missingItems.length">
                            <p class="mb-1 font-semibold">
                                {{ $t('Missing materials') }}
                            </p>
                            <ul class="flex flex-col gap-0.5">
                                <li
                                    v-for="item in missingItems"
                                    :key="item.name"
                                    class="flex items-center justify-between gap-3"
                                >
                                    <span>{{ item.name }}</span>
                                    <span class="font-semibold">{{ item.missing }}</span>
                                </li>
                            </ul>
                        </template>
                    </template>
                </Tooltip>
            </template>
        </template>
    </Card>
</template>
