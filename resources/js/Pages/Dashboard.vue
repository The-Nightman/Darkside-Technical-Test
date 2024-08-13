<script setup lang="ts">
import CustomerDashboardCard from '@/Components/CustomerDashboardCard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CustomerCardData } from '@/types/customerCardData';
import { Head } from '@inertiajs/vue3';

defineProps<{
    customers: Array<CustomerCardData>;
}>();

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-2 py-6 sm:px-6 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="text-gray-900 dark:text-gray-100">Customers</h2>
                    <div class="mt-6 border border-gray-300 dark:border-gray-600 rounded-md">
                        <div
                            class="p-1 border-b border-gray-300 dark:border-gray-600 grid grid-cols-[min-content_auto_20%_min-content] md:grid-cols-[min-content_auto_25%_15%_min-content] lg:grid-cols-[min-content_25%_15%_auto_15%_min-content] gap-2 sm:gap-4 dark:text-gray-300">
                            <div class="w-10" />
                            <div class="flex items-center">
                                Name
                            </div>
                            <div class="hidden md:flex items-center">
                                Phone
                            </div>
                            <div class="hidden lg:flex items-center">
                                Email
                            </div>
                            <div class="flex items-center">
                                Rating
                            </div>
                            <div class="w-10" />
                        </div>
                        <ul>
                            <li class="border-b last:border-0 border-gray-300 dark:border-gray-600"
                                v-for="customer in customers" :key="customer.id">
                                <CustomerDashboardCard :customer="customer" />
                            </li>
                        </ul>
                    </div>
                    <!-- Implement Pagination Here -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
