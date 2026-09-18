<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
</script>

<template>
    <AppLayout :title="$t('Armors')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Armors')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="ArmorsIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" />
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
