<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <div class="relative z-0 mt-1">
                    <input type="text" name="Name" id="name"
                        class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/name"
                        placeholder="" v-model="form.name" required autocomplete="name" />
                    <label for="name"
                        className="peer-focus/name:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/name:left-0 peer-focus/name:text-blue-600 peer-focus/name:dark:text-blue-500 peer-placeholder-shown/name:scale-100 peer-placeholder-shown/name:translate-y-0 peer-focus/name:scale-75 peer-focus/name:-translate-y-6">
                        Name
                    </label>
                </div>

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <div class="relative z-0 mt-1">
                    <input type="email" name="Email" id="email"
                        class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/email"
                        placeholder="" v-model="form.email" required autocomplete="username" />
                    <label for="email"
                        className="peer-focus/email:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/email:left-0 peer-focus/email:text-blue-600 peer-focus/email:dark:text-blue-500 peer-placeholder-shown/email:scale-100 peer-placeholder-shown/email:translate-y-0 peer-focus/email:scale-75 peer-focus/email:-translate-y-6">
                        Email
                    </label>
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <div class="relative z-0 mt-1">
                    <input type="password" name="Password" id="password"
                        class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/password"
                        placeholder="" v-model="form.password" required autocomplete="new-password" />
                    <label for="password"
                        className="peer-focus/password:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/password:left-0 peer-focus/password:text-blue-600 peer-focus/password:dark:text-blue-500 peer-placeholder-shown/password:scale-100 peer-placeholder-shown/password:translate-y-0 peer-focus/password:scale-75 peer-focus/password:-translate-y-6">
                        Password
                    </label>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <div class="relative z-0 mt-1">
                    <input type="password" name="Password Confirmation" id="password_confirmation"
                        class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer/passwordConfirm"
                        placeholder="" v-model="form.password_confirmation" required autocomplete="new-password" />
                    <label for="password"
                        className="peer-focus/passwordConfirm:font-medium absolute text-sm text-gray-500 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus/passwordConfirm:left-0 peer-focus/passwordConfirm:text-blue-600 peer-focus/passwordConfirm:dark:text-blue-500 peer-placeholder-shown/passwordConfirm:scale-100 peer-placeholder-shown/passwordConfirm:translate-y-0 peer-focus/passwordConfirm:scale-75 peer-focus/passwordConfirm:-translate-y-6">
                        Confirm Password
                    </label>
                </div>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
