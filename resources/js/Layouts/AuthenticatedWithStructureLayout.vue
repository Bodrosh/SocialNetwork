<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <MainHeading :title="title" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-4 bg-white overflow-hidden px-4 shadow-sm sm:rounded-lg">
                    <slot />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import MainHeading from "@/Components/UI/Text/MainHeading.vue";

defineProps({
    title: {
        required: true,
        type: String
    }
})
</script>

<style scoped>

</style>
