<script setup lang="ts">
import CustomerDashboardCard from '@/Components/CustomerDashboardCard.vue';
import Paginator from '@/Components/Paginator.vue';
import Toast from '@/Components/Toast.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CustomerCardData } from '@/types/customerCardData';
import useDebounce from '@/utils/debounce';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, ref, watch } from 'vue';

interface QueryParams {
    rating?: string;
    sortBy?: string;
    order?: string;
    search?: string;
}

interface PaginatedCustomers {
    data: CustomerCardData[];
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}

defineProps<{
    customers: PaginatedCustomers;
}>();

const params = ref<QueryParams>(route().queryParams);

const ratingDisplay = ref<string>(params.value.rating || '');

// debounce search input to prevent a request on each keypress
const search = ref<string>(params.value.search || '');
const debouncedSearch = useDebounce((value: string) => {
    // if search is used other filters are not needed
    // this handles the rating select not being reset accordingly
    ratingDisplay.value = '';

    router.visit(route('dashboard', { search: value }), {
        preserveState: true,
        preserveScroll: true
    });
}, 600)

watch(search, (newValue) => {
    debouncedSearch(newValue);
});

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
    toast.show = true;
    toast.message = message;
    toast.success = success;
    // Hide the toast after 4 seconds to give the user enough time to read it
    setTimeout(() => {
        toast.show = false;
    }, 4000);
};

const handleRatingFilter = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const rating = target.value;
    if (rating) {
        ratingDisplay.value = rating;
        params.value.rating = rating;
    } else {
        ratingDisplay.value = '';
        delete params.value.rating;
    }
    // forces navigation with new query params
    router.visit(route('dashboard', params.value));
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
                    <div
                        class="px-2 pt-6 pb-12 sm:px-6 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="text-gray-900 dark:text-gray-100">Customers</h2>
                        <div class="relative flex mt-6 ">
                            <input
                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 placeholder:dark:text-gray-100"
                                type="text" maxlength="70" aria-label="Search for a customer" v-model="search"
                                placeholder="Search for a customer">
                            <div class="absolute bottom-3 right-2 w-6 text-gray-900 dark:text-gray-100">
                                <svg data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                        fill-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 border border-gray-300 dark:border-gray-600 rounded-md">
                            <div
                                class="p-1 border-b border-gray-300 dark:border-gray-600 grid grid-cols-[min-content_auto_20%_min-content] md:grid-cols-[min-content_auto_25%_15%_min-content] lg:grid-cols-[min-content_25%_15%_auto_15%_min-content] gap-2 sm:gap-4 dark:text-gray-300 font-semibold sm:text-lg">
                                <div class="w-10" />
                                <div class="flex items-center">
                                    Name
                                    <div class="flex flex-col ml-auto mr-2">
                                        <Link :href="route('dashboard', [{ ...params, sortBy: 'name', order: 'asc' }])"
                                            class="w-12 h-fit"
                                            :class="{ 'text-lime-500': params.sortBy === 'name' && params.order === 'asc' || !Object.keys(params).length }"
                                            aria-label="Sort by name ascending" as="button">
                                        <svg data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 5 20 10"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z"
                                                fill-rule="evenodd" />
                                        </svg>
                                        </Link>
                                        <Link :href="route('dashboard', [{ ...params, sortBy: 'name', order: 'desc' }])"
                                            class="w-12 h-fit"
                                            :class="{ 'text-red-500': params.sortBy === 'name' && params.order === 'desc' }"
                                            aria-label="Sort by name descending" as="button">
                                        <svg data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 5 20 10"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                                fill-rule="evenodd" />
                                        </svg>
                                        </Link>
                                    </div>
                                </div>
                                <div class="hidden md:flex items-center">
                                    Phone
                                </div>
                                <div class="hidden lg:flex items-center">
                                    Email
                                </div>
                                <div class="flex items-center">
                                    <!-- z-index to not obscure buttons, negative margin to align with text below otherwise it looks uncannily off -->
                                    <select
                                        class="z-0 appearance-none bg-transparent border-none p-[0_2rem_0_0] -ml-[0.125rem] sm:text-lg"
                                        name="Rating" aria-label="Rating filter" aria-describedby="ratingFilterDesc"
                                        @change="handleRatingFilter" v-model="ratingDisplay" id="rating" placeholder="">
                                        <option value="">Rating</option>
                                        <option value="bronze">Bronze</option>
                                        <option value="silver">Silver</option>
                                        <option value="gold">Gold</option>
                                        <option value="platinum">Platinum</option>
                                    </select>
                                    <span id="ratingFilterDesc" class="sr-only">Select a customer rating filter to
                                        search
                                        for</span>
                                    <!-- z-index and -margin set to fix forced misalignment on small device screens, does not obscure or impact useability -->
                                    <div class="z-[1] flex flex-col -ml-4 sm:ml-auto mr-2">
                                        <Link :href="route('dashboard', [{ sortBy: 'rating' }, { order: 'asc' }])"
                                            class="w-12 h-fit"
                                            :class="{ 'text-lime-500': params.sortBy === 'rating' && params.order === 'asc' }"
                                            aria-label="Sort by rating ascending" as="button">
                                        <svg data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 5 20 10"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z"
                                                fill-rule="evenodd" />
                                        </svg>
                                        </Link>
                                        <Link :href="route('dashboard', [{ sortBy: 'rating' }, { order: 'desc' }])"
                                            class="w-12 h-fit"
                                            :class="{ 'text-red-500': params.sortBy === 'rating' && params.order === 'desc' }"
                                            aria-label="Sort by rating descending" as="button">
                                        <svg data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 5 20 10"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                                fill-rule="evenodd" />
                                        </svg>
                                        </Link>
                                    </div>
                                </div>
                                <div class="w-10" />
                            </div>
                            <ul>
                                <li class="border-b last:border-0 border-gray-300 dark:border-gray-600"
                                    v-for="customer in customers.data" :key="customer.id">
                                    <!-- emit currently not working -->
                                    <CustomerDashboardCard :customer="customer" @customerDeleted="showToast" />
                                </li>
                            </ul>
                        </div>
                        <Link
                            class="inline-flex items-center mt-4 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            :href="route('customer.create')" as="button">add new customer</Link>
                            <Paginator :links="customers.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
