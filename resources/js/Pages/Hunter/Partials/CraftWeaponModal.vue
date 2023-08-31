<script setup>
import {computed, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import _ from "lodash";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import CogIcon from "@/Components/Icons/CogIcon.vue";
import Wrench from "@/Components/Icons/Wrench.vue";

const props = defineProps({
    campaign: Object,
    hunter: Object,
    weapon: Object,
    classContainer: String,
})

const confirmingCraftWeapon = ref(false);
const confirmCraftWeapon = () => {
    confirmingCraftWeapon.value = true;
};

const craftWeapon = () => {
    form.post(route('campaigns.hunters.weapons.craft', [props.campaign, props.hunter, props.weapon.type, props.weapon]), {
        errorBag: 'craftWeaponHunter',
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const form = useForm({});
const formEquip = useForm({equip: false});
const closeModal = () => {
    confirmingCraftWeapon.value = false;

    form.reset();
};

const countItemHunter = (itemId) => {
    const hunterItemCount = _.find(props.hunter.items, (hunterItem) => {
        return itemId === hunterItem.pivot.item_id
    });
    if (hunterItemCount) {
        return hunterItemCount.pivot.number;
    }

    return 0;
}
const hunterWeaponCount = (weapon) => {
    return _.filter(props.hunter.weapons, (hunterWeapon) => {
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
    <div
        :class="`relative border rounded border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 p-2 text-gray-800 dark:text-gray-200 ${classContainer}`"
    >
        <slot />
        <div
            v-if="!weapon.is_default || weapon.equipped || hunterWeaponCount(weapon)"
            class="border-t border-gray-500 mt-2 pt-2 flex flex-col gap-2"
        >
            <SecondaryButton
                v-if="weapon.equipped"
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
                v-else-if="hunterWeaponCount(weapon)"
                class="w-full justify-center gap-2 group"
                :class="{ 'opacity-25': formEquip.processing }"
                :disabled="formEquip.processing"
                @click="equip"
            >
                <CogIcon class="w-4 h-4 group-hover:rotate-180 group-hover:text-green-500 transition-all" />
                {{ $t('Equip') }}
            </SecondaryButton>
            <SecondaryButton
                v-if="!weapon.is_default"
                class="w-full justify-center gap-2 group"
                @click="confirmCraftWeapon"
            >
                <Wrench class="w-4 h-4 group-hover:text-green-500 transition-all" />
                {{ $t('Craft') }}
            </SecondaryButton>
        </div>
    </div>
    <DialogModal
        :show="confirmingCraftWeapon"
        @close="closeModal"
    >
        <template #title>
            <div class="flex items-center gap-4">
                <div class="bg-gray-300 dark:bg-gray-900 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                    <WeaponsIcon
                        class="h-4 w-4"
                        :class="getRarityColor(weapon.rarity)"
                    />
                </div>
                <span>
                    {{ $t('Craft') }} "{{ weapon.name }}"
                </span>
                <CogIcon
                    v-if="weapon.is_default"
                    class="w-6 h-6"
                />
            </div>
        </template>

        <template #content>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div class="w-full border rounded">
                    <table class="dark:text-white w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="p-2">
                                    {{ $t('Item') }}
                                </th>
                                <th class="p-2">
                                    {{ $t('Count') }}
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
                                <td
                                    class="p-2 text-right"
                                    :class="hunterWeaponCount(props.weapon.parent) < 1 ? 'text-red-500' : ''"
                                >
                                    {{ hunterWeaponCount(props.weapon.parent) }}
                                </td>
                            </tr>
                            <tr
                                v-for="item in weapon.items"
                                :key="item.id"
                            >
                                <td class="p-2">
                                    {{ item.name }}
                                </td>
                                <td class="p-2 text-right">
                                    {{ item.pivot.number }}
                                </td>
                                <td
                                    class="p-2 text-right"
                                    :class="countItemHunter(item.id) < item.pivot.number ? 'text-red-500' : ''"
                                >
                                    {{ countItemHunter(item.id) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
