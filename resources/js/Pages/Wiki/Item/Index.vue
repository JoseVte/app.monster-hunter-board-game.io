<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ItemsIcon from "@/Components/Icons/ItemsIcon.vue";
</script>

<template>
    <AppLayout :title="$t('Items')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Items')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="ItemsIcon"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" />
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
