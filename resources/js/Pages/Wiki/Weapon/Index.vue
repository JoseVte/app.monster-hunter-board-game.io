<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
</script>

<template>
    <AppLayout :title="$t('Weapons')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Weapons')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                ]"
                :icon="WeaponsIcon"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" />
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
