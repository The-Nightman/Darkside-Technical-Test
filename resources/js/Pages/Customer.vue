<script lang="ts" setup>
import Checkbox from '@/Components/Checkbox.vue';
import Toast from '@/Components/Toast.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CustomerData } from '@/types/customerData';
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const props = defineProps<{ customer: CustomerData }>();

const form = reactive<CustomerData>({ ...props.customer });

const edit = ref<boolean>(false);

const toast = reactive<{ show: boolean; message: string; success: boolean; }>({
    show: false,
    message: "",
    success: false,
});

/**
 * Submit the form data to the server.
 */
const submitForm = () => {
    if (!form.id) {
        router.post(route('customer.store'), form, {
            onSuccess: () => {
                showToast("Customer added successfully", true);
                edit.value = false;
            },
            onError: (error) => {
                for (const key in error) {
                    if (error.hasOwnProperty(key)) {
                        showToast(error[key], false);
                    }
                }
            },
        });
    } else {
        router.put(route('customer.update', { id: props.customer.id }), form, {
            onSuccess: () => {
                showToast("Details saved successfully", true);
                edit.value = false;
            },
            onError: (error) => {
                for (const key in error) {
                    if (error.hasOwnProperty(key)) {
                        showToast(error[key], false);
                    }
                }
            },
        });
    }
};

/**
 * Handle Edit Button Click, revert form to original values if edit is cancelled
 */
const toggleEdit = () => {
    edit.value = !edit.value;
    if (!edit.value) {
        form.name = props.customer.name;
        form.email = props.customer.email;
        form.phone = props.customer.phone;
        form.house_number = props.customer.house_number;
        form.address_1 = props.customer.address_1;
        form.address_2 = props.customer.address_2;
        form.postcode = props.customer.postcode;
        form.city = props.customer.city;
        form.state = props.customer.state;
        form.country = props.customer.country;
        form.rating = props.customer.rating;
        form.rating_manual = props.customer.rating_manual;
    }
};

/**
 * Show a toast notification with the given message and type.
 * @param {string} message - The message to display in the toast.
 * @param {boolean} success - The type of the toast (success = true, error = fail).
 */
const showToast = (message: string, success: boolean) => {
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

    <Head :title="customer.name || 'New Customer'" />
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ customer.name || 'New Customer' }}
            </h1>
        </template>
        <div class="relative">
            <Toast v-if="toast.show" :message="toast.message" :success="toast.success" />
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="px-2 pt-6 pb-8 sm:px-6 bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex justify-end">
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                @click="toggleEdit">
                                <span v-if="edit">Cancel</span>
                                <span v-if="!edit">Edit</span>
                            </button>
                        </div>
                        <form class="flex flex-col" @submit.prevent="submitForm">
                            <fieldset class="flex flex-col sm:flex-row justify-between">
                                <legend class="mb-6 text-lg font-semibold text-gray-800 dark:text-gray-200">Customer
                                    Information
                                </legend>
                                <div class="flex flex-col mt-8 gap-8 text-gray-800 dark:text-gray-200">
                                    <div class="flex w-full sm:w-96 justify-center">
                                        <img class="w-1/2 rounded-full"
                                            src="../../images/Profile_avatar_placeholder.png"
                                            alt="Customer Avatar image">
                                    </div>
                                    <fieldset class="flex flex-col gap-3">
                                        <div class="relative z-0 w-full sm:w-96">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/name"
                                                v-model="form.name" type="text" id="name" name="name" placeholder=""
                                                aria-description="Enter customer full name" required
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/name:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/name:left-0 peer-focus/name:text-blue-600 peer-focus/name:dark:text-blue-500 peer-placeholder-shown/name:scale-100 peer-placeholder-shown/name:translate-y-0 peer-focus/name:scale-75 peer-focus/name:-translate-y-6"
                                                for="name">Name</label>
                                        </div>
                                        <div class="relative z-0 w-full sm:w-96">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/email"
                                                v-model="form.email" type="email" id="email" name="email" placeholder=""
                                                aria-description="Enter customer email" required :readonly="!edit" />
                                            <label
                                                class="peer-focus/email:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/email:left-0 peer-focus/email:text-blue-600 peer-focus/email:dark:text-blue-500 peer-placeholder-shown/email:scale-100 peer-placeholder-shown/email:translate-y-0 peer-focus/email:scale-75 peer-focus/email:-translate-y-6"
                                                for="email">Email</label>
                                        </div>
                                        <div class="relative z-0 w-full sm:w-64">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/tel"
                                                v-model="form.phone" type="tel" id="telephone" name="telephone"
                                                placeholder="" aria-description="Enter customer phone number" required
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/tel:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/tel:left-0 peer-focus/tel:text-blue-600 peer-focus/tel:dark:text-blue-500 peer-placeholder-shown/tel:scale-100 peer-placeholder-shown/tel:translate-y-0 peer-focus/tel:scale-75 peer-focus/tel:-translate-y-6"
                                                for="telephone">Telephone</label>
                                        </div>
                                        <div class="flex flex-row gap-4">
                                            <div>
                                                <label class="block text-base text-gray-900 dark:text-gray-300"
                                                    for="rating">Rating
                                                    <select
                                                        class="block py-2.5 px-0 w-24 text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                                        v-model="form.rating" id="rating" name="rating" placeholder=""
                                                        aria-description="Enter customer rating" required
                                                        :disabled="!edit || !form.rating_manual">
                                                        <option class="dark:bg-gray-400" value="Bronze">Bronze</option>
                                                        <option class="dark:bg-gray-400" value="Silver">Silver</option>
                                                        <option class="dark:bg-gray-400" value="Gold">Gold</option>
                                                        <option class="dark:bg-gray-400" value="Platinum">Platinum
                                                        </option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="flex">
                                                <label class="self-center select-none">
                                                    <Checkbox v-model:checked="form.rating_manual" :disabled="!edit" />
                                                    <span class="ml-2">Assign ratings manually?</span>
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <fieldset class="flex flex-col sm:w-1/2 mt-8 gap-8">
                                    <legend class="mb-6 text-lg font-semibold text-gray-800 dark:text-gray-200">Address
                                    </legend>
                                    <div class="flex flex-col w-full gap-3">
                                        <div class="relative z-0 w-40">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/housenum"
                                                v-model="form.house_number" type="text" id="houseNumber"
                                                name="houseNumber" placeholder=""
                                                aria-description="Enter customer house or building number" required
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/housenum:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/housenum:left-0 peer-focus/housenum:text-blue-600 peer-focus/housenum:dark:text-blue-500 peer-placeholder-shown/housenum:scale-100 peer-placeholder-shown/housenum:translate-y-0 peer-focus/housenum:scale-75 peer-focus/housenum:-translate-y-6"
                                                for="houseNumber">House/Building No.</label>
                                        </div>
                                        <div class="relative z-0 w-full">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/address1"
                                                v-model="form.address_1" type="text" id="addressLine1"
                                                name="addressLine1" placeholder=""
                                                aria-description="Enter the first line of customer address" required
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/address1:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/address1:left-0 peer-focus/address1:text-blue-600 peer-focus/address1:dark:text-blue-500 peer-placeholder-shown/address1:scale-100 peer-placeholder-shown/address1:translate-y-0 peer-focus/address1:scale-75 peer-focus/address1:-translate-y-6"
                                                for="addressLine1">Address Line 1</label>
                                        </div>
                                        <div class="relative z-0 w-full">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/address2"
                                                v-model="form.address_2" type="text" id="addressLine2"
                                                name="addressLine2" placeholder=""
                                                aria-description="Enter the second line of customer address (optional)"
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/address2:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/address2:left-0 peer-focus/address2:text-blue-600 peer-focus/address2:dark:text-blue-500 peer-placeholder-shown/address2:scale-100 peer-placeholder-shown/address2:translate-y-0 peer-focus/address2:scale-75 peer-focus/address2:-translate-y-6"
                                                for="addressLine2">Address Line 2 (Optional)</label>
                                        </div>
                                        <div class="relative z-0 w-full">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/postcode"
                                                v-model="form.postcode" type="text" id="postcode" name="postcode"
                                                placeholder="" aria-description="Enter customer postal or zip code"
                                                required :readonly="!edit" />
                                            <label
                                                class="peer-focus/postcode:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/postcode:left-0 peer-focus/postcode:text-blue-600 peer-focus/postcode:dark:text-blue-500 peer-placeholder-shown/postcode:scale-100 peer-placeholder-shown/postcode:translate-y-0 peer-focus/postcode:scale-75 peer-focus/postcode:-translate-y-6"
                                                for="postcode">Postcode</label>
                                        </div>
                                    </div>
                                    <div class="flex flex-col w-full gap-3">
                                        <div class="relative z-0 w-full">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/town"
                                                v-model="form.city" type="text" id="town" name="town" placeholder=""
                                                aria-description="Enter customer Town or City of residence" required
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/town:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/town:left-0 peer-focus/town:text-blue-600 peer-focus/town:dark:text-blue-500 peer-placeholder-shown/town:scale-100 peer-placeholder-shown/town:translate-y-0 peer-focus/town:scale-75 peer-focus/town:-translate-y-6"
                                                for="town">Town/City</label>
                                        </div>
                                        <div class="relative z-0 w-full">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/county"
                                                v-model="form.state" type="text" id="countyState" name="countyState"
                                                placeholder=""
                                                aria-description="Enter customer County or State of residence" required
                                                :readonly="!edit" />
                                            <label
                                                class="peer-focus/county:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/county:left-0 peer-focus/county:text-blue-600 peer-focus/county:dark:text-blue-500 peer-placeholder-shown/county:scale-100 peer-placeholder-shown/county:translate-y-0 peer-focus/county:scale-75 peer-focus/county:-translate-y-6"
                                                for="countyState">County/State</label>
                                        </div>
                                        <div class="relative z-0 w-full">
                                            <input
                                                class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/country"
                                                v-model="form.country" type="text" id="country" name="country"
                                                placeholder="" aria-description="Enter customer Country of residence"
                                                required :readonly="!edit" />
                                            <label
                                                class="peer-focus/country:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/country:left-0 peer-focus/country:text-blue-600 peer-focus/country:dark:text-blue-500 peer-placeholder-shown/country:scale-100 peer-placeholder-shown/country:translate-y-0 peer-focus/country:scale-75 peer-focus/country:-translate-y-6"
                                                for="country">Country</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <button
                                class="h-10 w-32 mt-8 mx-auto rounded text-white text-lg bg-blue-500 hover:bg-blue-400 active:bg-blue-600"
                                v-if="edit" type="submit" aria-label="Save customer details">
                                Save Details
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
