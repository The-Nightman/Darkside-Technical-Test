<script lang="ts" setup>
defineProps<{
    message: string;
    success: boolean;
}>();
</script>

<template>
    <div role="alert" aria-live="polite" :class="`absolute top-0 flex h-16 w-full items-center justify-center ${success ? 'bg-lime-400' : 'bg-red-500'}`">
        <p class="text-white text-xl">{{ message }}</p>
    </div>
</template>
