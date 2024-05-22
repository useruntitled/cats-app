<template>
    <app-router-link :to="{ name: 'user', params: { id: props.user.id } }">
        <div class="flex items-center space-x-2" :class="[fontSizeClass]">
            <div v-if="user.has_avatar">
                <LazyMedia
                    :media="user.avatar"
                    width="30"
                    height="30"
                    rounded="full"
                    class="border-4 dark:border-stone-800"
                />
            </div>
            <div>
                {{ user.name }}
            </div>
        </div>
    </app-router-link>
</template>
<script setup lang="ts">
import { computed } from "vue";
import AppRouterLink from "@/Components/AppRouterLink.vue";
import { User } from "@/types";
import LazyMedia from "@/Components/Media/LazyMedia.vue";

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
