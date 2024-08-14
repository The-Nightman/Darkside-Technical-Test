<script setup lang="ts">
import CustomerDashboardCard from '@/Components/CustomerDashboardCard.vue';
import Toast from '@/Components/Toast.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CustomerCardData } from '@/types/customerCardData';
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps<{
    customers: Array<CustomerCardData>;
}>();

const toast = reactive<{ show: boolean; message: string; success: boolean; }>({
    show: false,
    message: "",
    success: false,
});

/**
 * Show a toast notification with the given message and type.
 * @param {string} message - The message to display in the toast.
 * @param {boolean} success - The type of the toast (success = true, error = fail).
 */
const showToast = ({ message, success }: { message: string, success: boolean }) => {
    console.log("message, success");
    toast.show = true;
    toast.message = message;
    toast.success = success;
    // Hide the toast after 4 seconds to give the user enough time to read it
    setTimeout(() => {
        toast.show = false;
    }, 4000);
};

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h1>
        </template>
        <div class="relative">
            <Toast v-if="toast.show" :message="toast.message" :success="toast.success" />
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="px-2 pt-6 pb-12 sm:px-6 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
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
                                    <!-- emit currently not working -->
                                    <CustomerDashboardCard :customer="customer" @customerDeleted="showToast" />
                                </li>
                            </ul>
                        </div>
                        <Link
                            class="inline-flex items-center mt-4 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            :href="route('customer.create')" as="button">add new customer</Link>
                        <!-- Implement Pagination Here -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
