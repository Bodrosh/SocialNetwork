<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <MainHeading title="Панель управления" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-2 shadow-sm sm:rounded-lg">
                    <Link :href="route('user.personal')">
                        <PrimaryButton>Социальная сеть</PrimaryButton>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MainHeading from "@/Components/UI/Text/MainHeading.vue";
</script>
