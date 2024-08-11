<script setup lang="ts">
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
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="w-full max-w-2xl lg:max-w-7xl">
                <header class="flex items-center justify-center">
                    <div
                        class="flex flex-col w-full p-8 rounded-2xl items-center bg-white dark:bg-gray-700 shadow-2xl select-none">
                        <img class="mx-auto rounded-full" src="../../images/dslogo.png"
                            alt="Darkside Developments Company Logo">
                        <h1 class="text-2xl">Internal Customer Dashboard</h1>
                        <nav v-if="canLogin" class="mt-6 flex flex-col w-32 gap-2 text-center">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                class="rounded-md px-3 py-2 bg-blue-400 hover:bg-blue-300 active:bg-blue-500 dark:bg-zinc-400 dark:hover:bg-slate-300 dark:active:bg-slate-500 text-black active:text-white ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-black dark:active:text-white dark:focus-visible:ring-white"
                                draggable="false">
                            Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')"
                                    class="rounded-md px-3 py-2 bg-blue-400 hover:bg-blue-300 active:bg-blue-500 dark:bg-zinc-400 dark:hover:bg-slate-300 dark:active:bg-slate-500 text-black active:text-white ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-black dark:active:text-white dark:focus-visible:ring-white"
                                    draggable="false">
                                Log in
                                </Link>
                                <Link v-if="canRegister" :href="route('register')"
                                    class="rounded-md px-3 py-2 bg-blue-400 hover:bg-blue-300 active:bg-blue-500 dark:bg-zinc-400 dark:hover:bg-slate-300 dark:active:bg-slate-500 text-black active:text-white ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-black dark:active:text-white dark:focus-visible:ring-white"
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
