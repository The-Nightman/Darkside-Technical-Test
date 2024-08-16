<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}>();

const currentUrl: URL = new URL(window.location.href);
const baseUrl: string = `${currentUrl.origin}${currentUrl.pathname}`;

const processedLinks = props.links.map((link, index) => {
    if (link.label === "...") {
        return {
            ...link,
            url: `${baseUrl}?page=${parseInt(props.links[index - 1].label) +
                Math.floor(
                    (parseInt(props.links[index + 1].label) -
                        parseInt(props.links[index - 1].label)) /
                    2
                )
                }`,
        };
    }
    return {
        ...link,
    };
});

const ariaLabel = (index: number) => {
    if (index === 0) return "Previous page";
    if (index === props.links.length - 1) return "Next page";
    if (processedLinks[index].label === "...") {
        const pageNumberMatch = processedLinks[index].url!.match(/page=(\d+)/);
        const pageNumber = pageNumberMatch ? pageNumberMatch[1] : index;
        return `Skip to page ${pageNumber}`;
    }
    return `Page ${index}`;
};
</script>

<template>
    <div class="flex flex-row justify-center items-center">
        <Link class="mx-4 w-6 text-center text-lg font-semibold" :class="{
            'text-red-600 dark:text-blue-400 text-xl underline': link.active,
            'text-gray-800 dark:text-gray-200': !link.active,
        }" v-for="(link, index) in processedLinks" :href="link.url ?? '#'" :aria-label="ariaLabel(index)">
        <template v-if="index !== 0 && index !== links.length - 1">
            {{ link.label }}
        </template>
        <svg class="w-10" v-if="index === 0" data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd"
                d="M4.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L6.31 10l3.72-3.72a.75.75 0 1 0-1.06-1.06L4.72 9.47Zm9.25-4.25L9.72 9.47a.75.75 0 0 0 0 1.06l4.25 4.25a.75.75 0 1 0 1.06-1.06L11.31 10l3.72-3.72a.75.75 0 0 0-1.06-1.06Z"
                fill-rule="evenodd"></path>
        </svg>
        <svg class="w-10" v-if="index === links.length - 1" data-slot="icon" aria-hidden="true" fill="currentColor"
            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd"
                d="M15.28 9.47a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L13.69 10 9.97 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25ZM6.03 5.22l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L8.69 10 4.97 6.28a.75.75 0 0 1 1.06-1.06Z"
                fill-rule="evenodd"></path>
        </svg>
        </Link>
    </div>
</template>
