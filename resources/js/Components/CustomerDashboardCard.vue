<script lang="ts" setup>
import { CustomerCardData } from '@/types/customerCardData';
import Dropdown from './Dropdown.vue';
import DropdownLink from './DropdownLink.vue';
import { router } from '@inertiajs/vue3';

defineProps<{ customer: CustomerCardData }>();

const emit = defineEmits(['customerDeleted']);

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(route('customer.destroy', { id: id }), {
            preserveScroll: true,
            // emits currently not working
            onSuccess: () => {
                emit('customerDeleted', { message: 'Customer deleted successfully', success: true });
            },
            onError: (error) => {
                for (const key in error) {
                    if (error.hasOwnProperty(key)) {
                        emit('customerDeleted', { message: error[key], success: false });
                    }
                }
            },
        })
    }
};

</script>

<template>
    <div
        class="p-1 grid grid-cols-[min-content_auto_20%_min-content] md:grid-cols-[min-content_auto_25%_15%_min-content] lg:grid-cols-[min-content_25%_15%_auto_15%_min-content] gap-2 sm:gap-4 dark:text-gray-300">
        <div class="flex items-center w-max">
            <img class="w-10 aspect-square rounded-full" :src="customer.avatar" alt="customer profile image" />
        </div>
        <div class="flex items-center">{{ customer.name }}</div>
        <address class="hidden md:flex items-center">{{ customer.phone }}</address>
        <address class="hidden lg:flex items-center">{{ customer.email }}</address>
        <div class="flex items-center">{{ customer.rating }}</div>
        <!-- Dropdown Menu -->
        <div class="flex items-center relative">
            <Dropdown align="right" width="48">
                <!-- Button -->
                <template #trigger>
                    <span class="flex items-center rounded-md">
                        <button type="button" :name="`options-${customer.name}`"
                            :aria-label="`Options for ${customer.name}`"
                            class="inline-flex items-center border border-transparent rounded-md bg-white dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-500 focus:outline-none focus:outline-gray-500 transition ease-in-out duration-150">
                            <svg class="w-10 text-black dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-100"
                                viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                ml-update="aware">
                                <g clip-path="url(#clip0_105_1881)">
                                    <rect height="0.01" stroke="currentColor" stroke-linejoin="round" stroke-width="3"
                                        transform="rotate(90 12.01 12)" width="0.01" x="12.01" y="12" />
                                    <rect height="0.01" stroke="currentColor" stroke-linejoin="round" stroke-width="3"
                                        transform="rotate(90 19.01 12)" width="0.01" x="19.01" y="12" />
                                    <rect height="0.01" stroke="currentColor" stroke-linejoin="round" stroke-width="3"
                                        transform="rotate(90 5.01001 12)" width="0.01" x="5.01001" y="12" />
                                </g>
                            </svg>
                        </button>
                    </span>
                </template>
                <!-- Dropdown Options -->
                <template #content>
                    <DropdownLink :href="route('customer.show', { id: customer.id })" as="button"> View </DropdownLink>
                    <button
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 bg-red-600/50 hover:bg-red-600 dark:hover:bg-red-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out"
                        @click="() => handleDelete(customer.id)"> Delete </button>
                </template>
            </Dropdown>
        </div>
    </div>
</template>
