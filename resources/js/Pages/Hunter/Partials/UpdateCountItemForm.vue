<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import CountForm from "@/Components/Form/CountForm.vue";

const props = defineProps({
    canEdit: Boolean,
    hideEmpty: Boolean,
    campaign: Object,
    hunter: Object,
    item: Object,
    countItem: Number,
});

const form = useForm({
    count_item: props.countItem,
});

const incrementItem = () => {
    form.count_item++;
    form.put(route('campaigns.hunters.items.update-count', [props.campaign, props.hunter, props.item]), {
        errorBag: 'updateHunterItem',
        preserveScroll: true,
    });
}
const decrementItem = () => {
    form.count_item--;
    form.put(route('campaigns.hunters.items.update-count', [props.campaign, props.hunter, props.item]), {
        errorBag: 'updateHunterItem',
        preserveScroll: true,
    });
}
</script>

<template>
    <div
        v-if="!(hideEmpty && countItem === 0)"
        class="flex items-center justify-between"
    >
        <div class="text-gray-800 dark:text-white font-semibold">
            <Link
                :href="route('wiki.item.show', item)"
                class="hover:underline"
            >
                {{ item.name }}
            </Link>
        </div>
        <div class="text-gray-700 dark:text-gray-100">
            <CountForm
                v-if="canEdit"
                :form="form"
                :decrement="decrementItem"
                :increment="incrementItem"
                :value="countItem"
                class="w-full mt-1"
            />
            <div
                v-else
                class="flex items-center justify-center h-10 rounded relative bg-transparent w-20 outline-none px-4 border-0 focus:outline-none text-center bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 font-semibold text-md "
            >
                {{ countItem }}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
