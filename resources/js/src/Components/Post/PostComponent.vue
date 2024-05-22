<template>
    <stateful-modal-link
        :func="
            () => {
                postsStore.set(post);
            }
        "
        :to="modalManager.getOpenPost(post.id)"
    >
        <div
            class="w-full py-4 px-5 dark:bg-secondary shadow-glow rounded-lg hover:brightness-[1.5] space-y-2 cursor-pointer"
        >
            <div>
                <UserComponent :user="post.author" />
            </div>
            <div class="font-bold text-3xl">
                {{ post.title }}
            </div>
            <div v-if="post.media">
                <FluidLazyMedia
                    :media="post.media"
                    max-height="600"
                    rounded="xl"
                />
            </div>
            <footer class="flex items-center space-x-2 opacity-80">
                <span>
                    <IconMessageDots class="w-6 h-8" stroke="1.5" />
                </span>
                <span>
                    {{ post.comments_count }}
                </span>
            </footer>
        </div>
    </stateful-modal-link>
</template>
<script setup lang="ts">
import UserComponent from "@/Components/User/UserComponent.vue";
import { Post } from "@/types";
import StatefulModalLink from "@/Components/StatefulModalLink.vue";
import { usePostsStore } from "@/stores/posts.store.ts";
import { modalManager } from "@/utils/modalManager.ts";
import FluidLazyMedia from "@/Components/Media/FluidLazyMedia.vue";
import { IconMessageDots } from "@tabler/icons-vue";
defineProps<{
    post: Post;
}>();

const postsStore = usePostsStore();
</script>
