<script setup lang="ts">
import DarkModeToggle from '@/Components/DarkModeToggle.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

</script>

<template>

    <Head title="Welcome" />
    <div
        class="bg-gradient-to-tr from-blue-500 to-pink-500 text-black/50 dark:bg-none dark:bg-zinc-800 dark:text-white/50">
        <div class="min-h-screen flex flex-col px-2 items-center justify-center">
            <div class="w-full max-w-2xl lg:max-w-7xl">
                <header class="flex items-center justify-center">
                    <DarkModeToggle class="absolute top-2 right-2" />
                    <div
                        class="flex flex-col w-full p-8 rounded-2xl items-center bg-white dark:bg-gray-700 shadow-2xl select-none">
                        <img src="../../images/dslogo.png" alt="Darkside Developments Company Logo" draggable="false">
                        <h1 class="my-2 text-2xl text-center">Internal Customer Dashboard</h1>
                        <nav v-if="canLogin" class="mt-6 flex flex-col w-32 gap-2 text-center">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                draggable="false">
                            Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')"
                                    class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    draggable="false">
                                Log in
                                </Link>
                                <Link v-if="canRegister" :href="route('register')"
                                    class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    draggable="false">
                                Register
                                </Link>
                            </template>
                        </nav>
                    </div>
                </header>
            </div>
            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </footer>
        </div>
    </div>
</template>
