<template>
    <app-router-link :to="to">
        <div
            class="dark:bg-secondary px-4 border-gray-200 inline-block py-3 dark:rounded-lg rounded-lg shadow-glow hover:brightness-[1.5]"
        >
            <slot />
        </div>
    </app-router-link>
</template>
<script setup>
import AppRouterLink from "@/Components/AppRouterLink.vue";
const props = defineProps({
    to: {
        required: true,
    },
});
</script>
