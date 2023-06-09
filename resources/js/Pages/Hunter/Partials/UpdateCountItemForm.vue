<script setup>
import {useForm} from "@inertiajs/vue3";
import CountForm from "@/Components/Form/CountForm.vue";

const props = defineProps({
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
    <div class="flex items-center justify-between">
        <div class="text-gray-800 dark:text-white font-semibold">
            {{ item.name }}
        </div>
        <div class="text-gray-700 dark:text-gray-100">
            <CountForm
                :form="form"
                :decrement="decrementItem"
                :increment="incrementItem"
                :value="countItem"
                class="w-full mt-1"
            />
        </div>
    </div>
</template>

<style scoped>

</style>
