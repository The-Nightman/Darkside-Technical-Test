<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Confirm Password" />
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <div class="relative z-0 mt-1">
                    <input type="password" name="Password" id="password"
                        class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/password"
                        placeholder="" v-model="form.password" required autocomplete="current-password" />
                    <label for="password"
                        className="peer-focus/password:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/password:left-0 peer-focus/password:text-blue-600 peer-focus/password:dark:text-blue-500 peer-placeholder-shown/password:scale-100 peer-placeholder-shown/password:translate-y-0 peer-focus/password:scale-75 peer-focus/password:-translate-y-6">
                        Password
                    </label>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
