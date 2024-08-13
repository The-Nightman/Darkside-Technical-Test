<script setup lang="ts">
import DarkModeToggle from '@/Components/DarkModeToggle.vue';
</script>

<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-tr from-blue-500 to-pink-500 dark:bg-none dark:bg-zinc-800">
        <DarkModeToggle class="absolute top-2 right-2" />
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-700 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
