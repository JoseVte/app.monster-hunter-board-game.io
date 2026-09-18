<script setup>
import {ref} from "vue";
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
    armor: Object,
})

const confirmingCraftArmor = ref(false);
const confirmCraftArmor = () => {
    confirmingCraftArmor.value = true;
};

const craftArmor = () => {
    form.post(route('campaigns.hunters.armors.craft', [props.campaign, props.hunter, props.armor]), {
        errorBag: 'craftArmorHunter',
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const form = useForm({});
const formEquip = useForm({equip: false});
const closeModal = () => {
    confirmingCraftArmor.value = false;

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

const hunterArmorCount = (armor) => {
    return _.filter(props.hunter.armors, (hunterArmor) => {
        return hunterArmor.id === armor.id;
    }).length;
}

const equip = () => {
    formEquip.equip = true;
    formEquip.put(route('campaigns.hunters.armors.equip', [props.campaign, props.hunter, props.armor]), {
        errorBag: 'equipArmorHunter',
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
}
const unequip = () => {
    formEquip.equip = false;
    formEquip.put(route('campaigns.hunters.armors.equip', [props.campaign, props.hunter, props.armor]), {
        errorBag: 'unequipArmorHunter',
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
}
</script>

<template>
    <!-- The rule is the bright one the components print, the same as a weapon
         card's, rather than a flat grey line. -->
    <div class="flex flex-col gap-2 pt-2 before:mb-2 before:block before:h-px before:w-full before:bg-[linear-gradient(to_right,transparent,var(--color-attack-line),transparent)] before:content-['']">
        <SecondaryButton
            v-if="armor.equipped"
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
            v-else-if="hunterArmorCount(armor)"
            class="w-full justify-center gap-2 group"
            :class="{ 'opacity-25': formEquip.processing }"
            :disabled="formEquip.processing"
            @click="equip"
        >
            <CogIcon class="w-4 h-4 group-hover:rotate-180 group-hover:text-primary-400 transition-all" />
            {{ $t('Equip') }}
        </SecondaryButton>
        <!-- Armour has no upgrade tree the way a weapon does, so once a piece is
             yours a second copy buys nothing and only spends the parts. -->
        <SecondaryButton
            v-if="!hunterArmorCount(armor)"
            class="w-full justify-center gap-2 group"
            @click="confirmCraftArmor"
        >
            <Wrench class="w-4 h-4 group-hover:text-primary-400 transition-all" />
            {{ $t('Craft') }}
        </SecondaryButton>
    </div>

    <DialogModal
        :show="confirmingCraftArmor"
        @close="closeModal"
    >
        <template #title>
            <div class="flex items-center gap-4">
                <div class="bg-gray-300 dark:bg-gray-900 rounded-full h-8 w-8 min-h-8 min-w-8 flex items-center justify-center">
                    <WeaponsIcon
                        class="h-4 w-4"
                        :class="getRarityColor(armor.rarity)"
                    />
                </div>
                <span>
                    {{ $t('Craft') }} "{{ armor.name }}"
                </span>
                <CogIcon
                    v-if="armor.is_default"
                    class="w-6 h-6"
                />
            </div>
        </template>

        <template #content>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div class="w-full rounded-sm border border-gray-300 dark:border-gray-700">
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
                            <tr
                                v-for="item in armor.items"
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
                v-if="armor.can_craft"
                id="craft-weapon-btn"
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="craftArmor"
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
