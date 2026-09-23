<script setup>
import {computed, ref, watch} from "vue";
import {Link, useForm} from "@inertiajs/vue3";
import _ from "lodash";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import CogIcon from "@/Components/Icons/CogIcon.vue";
import Wrench from "@/Components/Icons/Wrench.vue";
import WeaponTypeIcon from "@/Components/WeaponTypeIcon.vue";
import WeaponStats from "@/Components/WeaponStats.vue";
import AverageDamage from "@/Components/AverageDamage.vue";

const props = defineProps({
    campaign: Object,
    hunter: Object,
    weapon: Object,
    classContainer: [String, Array],
})

const confirmingCraftWeapon = ref(false);
const confirmCraftWeapon = () => {
    confirmingCraftWeapon.value = true;
};

const recipes = computed(() => props.weapon.recipes ?? []);

// A weapon buildable from two monsters costs different parts each way, so the
// player picks which to spend. The first one they can afford is the default.
const selectedRecipeId = ref(null);
const selectedRecipe = computed(() => recipes.value.find((recipe) => recipe.id === selectedRecipeId.value) ?? recipes.value[0]);

const canAfford = (recipe) => (props.weapon.craftable_recipes ?? []).includes(recipe.id);

watch(() => [confirmingCraftWeapon.value, recipes.value], () => {
    if (! confirmingCraftWeapon.value) {
        return;
    }

    const affordable = recipes.value.find((recipe) => canAfford(recipe));
    selectedRecipeId.value = (affordable ?? recipes.value[0])?.id ?? null;
}, { immediate: true });

// The weapons between what the hunter holds and this one, which have to be
// built before it and are what the accumulated column adds up. Empty whenever
// the weapon it upgrades from is already in hand, and on the wiki's own tree.
const missingChain = computed(() => props.weapon.missing_chain ?? []);
const showsTotal = computed(() => missingChain.value.length > 0);

// One row per item either the chain or this recipe asks for. An item only the
// chain needs has no number of its own for this step, which is not a zero.
const rows = computed(() => {
    const byId = new Map();

    (selectedRecipe.value?.items ?? []).forEach((item) => {
        byId.set(item.id, {id: item.id, name: item.name, step: item.pivot.number, total: item.pivot.number});
    });

    (props.weapon.chain_items ?? []).forEach((item) => {
        const row = byId.get(item.id);

        if (row) {
            row.total += item.number;

            return;
        }

        byId.set(item.id, {id: item.id, name: item.name, step: null, total: item.number});
    });

    return [...byId.values()];
});

// With the whole line to pay for, what is short is short against that total,
// which is the question the column is there to answer.
const isShort = (row) => countItemHunter(row.id) < (showsTotal.value ? row.total : row.step);

const craftWeapon = () => {
    form.recipe = selectedRecipeId.value;
    form.post(route('campaigns.hunters.weapons.craft', [props.campaign, props.hunter, props.weapon.type, props.weapon]), {
        errorBag: 'craftWeaponHunter',
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const form = useForm({recipe: null});
const formEquip = useForm({equip: false});
const closeModal = () => {
    confirmingCraftWeapon.value = false;

    form.reset();
};

const countItemHunter = (itemId) => {
    const hunterItemCount = _.find(props.hunter?.items ?? [], (hunterItem) => {
        return itemId === hunterItem.pivot.item_id
    });
    if (hunterItemCount) {
        return hunterItemCount.pivot.number;
    }

    return 0;
}
const hunterWeaponCount = (weapon) => {
    return _.filter(props.hunter?.weapons ?? [], (hunterWeapon) => {
        return hunterWeapon.id === weapon.id;
    }).length;
}

const equip = () => {
    formEquip.equip = true;
    formEquip.put(route('campaigns.hunters.weapons.equip', [props.campaign, props.hunter, props.weapon.type, props.weapon]), {
        errorBag: 'equipWeaponHunter',
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
}
const unequip = () => {
    formEquip.equip = false;
    formEquip.put(route('campaigns.hunters.weapons.equip', [props.campaign, props.hunter, props.weapon.type, props.weapon]), {
        errorBag: 'unequipWeaponHunter',
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
}
</script>

<template>
    <component
        :is="hunter ? 'div' : Link"
        :href="hunter ? undefined : route('wiki.weapon.show', weapon.id)"
        :class="[
            'mh-card',
            { 'mh-card-owned': hunter && (weapon.is_default || hunterWeaponCount(weapon)) },
            { 'mh-card-equipped': weapon.equipped },
            classContainer,
        ]"
    >
        <slot />
        <!-- Nothing to equip or craft when nobody is holding it, which is how the
             wiki draws the same card. -->
        <div
            v-if="hunter"
            class="mt-auto flex flex-col gap-2 border-t-0 pt-2 before:mb-2 before:block before:h-px before:w-full before:bg-[linear-gradient(to_right,transparent,var(--color-attack-line),transparent)] before:content-['']"
        >
            <!-- The starting weapon only ever goes on: taking it off would leave
                 the hunter with nothing of that type in hand. Equipping anything
                 else is how it leaves. -->
            <SecondaryButton
                v-if="weapon.equipped && weapon.is_default"
                class="w-full justify-center gap-2"
                disabled
            >
                <CogIcon class="w-4 h-4" />
                {{ $t('Equipped') }}
            </SecondaryButton>
            <SecondaryButton
                v-else-if="weapon.equipped"
                class="w-full justify-center gap-2 group"
                :class="{ 'opacity-25': formEquip.processing }"
                :disabled="formEquip.processing"
                @click="unequip"
            >
                <CogIcon class="w-4 h-4 group-hover:-rotate-180 group-hover:text-red-500 transition-all" />
                <span class="group-hover:hidden">{{ $t('Equipped') }}</span>
                <span class="hidden group-hover:inline">{{ $t('Unequip') }}</span>
            </SecondaryButton>
            <SecondaryButton
                v-else-if="weapon.is_default || hunterWeaponCount(weapon)"
                class="w-full justify-center gap-2 group"
                :class="{ 'opacity-25': formEquip.processing }"
                :disabled="formEquip.processing"
                @click="equip"
            >
                <CogIcon class="w-4 h-4 group-hover:rotate-180 group-hover:text-primary-400 transition-all" />
                {{ $t('Equip') }}
            </SecondaryButton>
            <SecondaryButton
                v-if="!weapon.is_default"
                class="w-full justify-center gap-2 group"
                @click="confirmCraftWeapon"
            >
                <Wrench class="w-4 h-4 group-hover:text-primary-400 transition-all" />
                {{ $t('Craft') }}
            </SecondaryButton>
        </div>
    </component>
    <DialogModal
        :show="confirmingCraftWeapon"
        @close="closeModal"
    >
        <template #title>
            <div class="flex items-center gap-4">
                <div class="bg-gray-300 dark:bg-gray-900 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                    <WeaponTypeIcon
                        :weapon-type="weapon.type"
                        class="h-4 w-4"
                        :class="getRarityColor(weapon.rarity)"
                    />
                </div>
                <span class="flex-1">
                    {{ $t('Craft') }} "{{ weapon.name }}"
                </span>
                <AverageDamage :weapon="weapon" />
                <CogIcon
                    v-if="weapon.is_default"
                    class="w-6 h-6"
                />
            </div>
        </template>

        <template #content>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <WeaponStats :weapon="weapon" />
                <div class="w-full rounded-sm border border-gray-300 dark:border-gray-700">
                    <div
                        v-if="recipes.length > 1"
                        class="mb-3 flex flex-wrap gap-2"
                    >
                        <button
                            v-for="recipe in recipes"
                            :key="recipe.id"
                            type="button"
                            class="rounded border px-3 py-1 text-sm"
                            :class="[
                                recipe.id === selectedRecipe?.id
                                    ? 'border-primary-500 bg-primary-500 text-white'
                                    : 'border-gray-300 dark:border-gray-600',
                                canAfford(recipe) ? '' : 'opacity-50',
                            ]"
                            @click="selectedRecipeId = recipe.id"
                        >
                            {{ recipe.branch }}
                            <span v-if="! canAfford(recipe)">&middot;</span>
                        </button>
                    </div>

                    <table class="dark:text-white w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="p-2">
                                    {{ $t('Item') }}
                                </th>
                                <th class="p-2">
                                    {{ $t('Count') }}
                                </th>
                                <th
                                    v-if="showsTotal"
                                    class="p-2"
                                >
                                    {{ $t('Accumulated total') }}
                                </th>
                                <th class="p-2">
                                    {{ $t('Hunter Items') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="weapon.parent">
                                <td class="p-2">
                                    {{ weapon.parent.name }}
                                </td>
                                <td class="p-2 text-right">
                                    1
                                </td>
                                <!-- What the parent costs is already counted in
                                     the column, so repeating it here would say
                                     the line has to be built twice. -->
                                <td
                                    v-if="showsTotal"
                                    class="p-2"
                                />
                                <td
                                    class="p-2 text-right"
                                    :class="hunterWeaponCount(props.weapon.parent) < 1 ? 'text-red-500' : ''"
                                >
                                    {{ hunterWeaponCount(props.weapon.parent) }}
                                </td>
                            </tr>
                            <tr
                                v-for="row in rows"
                                :key="row.id"
                            >
                                <td class="p-2">
                                    {{ row.name }}
                                </td>
                                <td class="p-2 text-right">
                                    {{ row.step ?? '—' }}
                                </td>
                                <td
                                    v-if="showsTotal"
                                    class="p-2 text-right font-semibold"
                                >
                                    {{ row.total }}
                                </td>
                                <td
                                    class="p-2 text-right"
                                    :class="isShort(row) ? 'text-red-500' : ''"
                                >
                                    {{ countItemHunter(row.id) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p
                    v-if="showsTotal"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ $t('The accumulated total also covers what these still cost:') }}
                    <span class="font-semibold">{{ missingChain.map((step) => step.name).join(', ') }}</span>
                </p>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                {{ $t('Cancel') }}
            </SecondaryButton>

            <PrimaryButton
                v-if="weapon.can_craft"
                id="craft-weapon-btn"
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="craftWeapon"
            >
                {{ $t('Craft') }}
            </PrimaryButton>
            <PrimaryButton
                v-else
                class="ml-3 opacity-25 cursor-not-allowed"
                disabled
            >
                {{ $t('Craft') }}
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
