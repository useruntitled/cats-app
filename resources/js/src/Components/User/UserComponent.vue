<template>
    <app-router-link :to="{ name: 'user', params: { id: props.user.id } }">
        <div class="flex items-center space-x-4" :class="[fontSizeClass]">
            <div>{{ user.has_avatar }}</div>
            <div>
                {{ user.name }}
            </div>
        </div>
    </app-router-link>
</template>
<script setup lang="ts">
import { computed } from "vue";
import AppRouterLink from "@/Components/AppRouterLink.vue";

type User = {
    id: number;
    name: string;
    has_avatar: boolean;
};

const props = withDefaults(
    defineProps<{
        user: User;
        fontSize?: string;
    }>(),
    {
        fontSize: "base",
    },
);

const fontSizeClass = computed(() => {
    return `text-${props.fontSize}`;
});
</script>
