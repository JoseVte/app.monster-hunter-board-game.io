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
const closeModal = () => {
    confirmingCraftArmor.value = false;

    form.reset();
};

const canCraftArmor = computed(() => {
    return !props.armor.is_default && _.filter(props.armor.items, (item) => {
        return item.pivot.number >  countItemHunter(item.id)
    }).length === 0;
})
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
</script>

<template>
    <div
        class="border-t border-gray-500 pt-2"
    >
        <SecondaryButton
            v-if="hunterArmorCount(armor)"
            class="w-full justify-center gap-2 group"
        >
            <CogIcon class="w-4 h-4 group-hover:rotate-180 group-hover:text-green-500 transition-all" />
            {{ $t('Equip') }}
        </SecondaryButton>
        <SecondaryButton
            v-else
            class="w-full justify-center gap-2 group"
            @click="confirmCraftArmor"
        >
            <Wrench class="w-4 h-4 group-hover:text-green-500 transition-all" />
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
                v-if="canCraftArmor"
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
