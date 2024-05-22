<template>
    <modal-component :show="props.show" @close="emit('close')">
        <modal-template @close="emit('close')">
            <template #header> Post Modal </template>
            <template #body>
                <div v-if="post" class="space-y-4">
                    <header class="flex flex-col">
                        <div><UserComponent :user="post.author" /></div>
                        <div class="text-3xl font-bold">
                            {{ post.title }}
                        </div>
                    </header>
                    <section v-if="post.media">
                        <FluidLazyMedia
                            :media="post.media"
                            max-height="800"
                            rounded="xl"
                        />
                    </section>
                    <section>
                        <div class="text-2xl my-4">
                            <h1>Comments</h1>
                        </div>
                        <CommentsSection
                            @refresh-comments="
                                (newComments) => (comments = newComments)
                            "
                            :comments="comments as Array<Comment>"
                            :post-id="post.id as Number"
                        />
                    </section>
                </div>
            </template>
        </modal-template>
    </modal-component>
</template>
<script setup lang="ts">
import ModalComponent from "@/Components/Modals/ModalComponent.vue";
import { useRoute } from "vue-router";
import { onMounted, ref, watch } from "vue";
import { postApi } from "@/api/postApi.ts";
import ModalTemplate from "@/Components/Modals/Templates/ModalTemplate.vue";
import { Post } from "@/types";
import { usePostsStore } from "@/stores/posts.store.ts";
import UserComponent from "@/Components/User/UserComponent.vue";
import FluidLazyMedia from "@/Components/Media/FluidLazyMedia.vue";
import { commentApi } from "@/api/commentApi.ts";
import { AxiosResponse } from "axios";
import CommentComponent from "@/Components/Comment/CommentComponent.vue";
import CommentInput from "@/Components/Comment/CommentInput.vue";
import CommentsSection from "@/Components/Comment/CommentsSection.vue";

const emit = defineEmits(["close"]);

const props = withDefaults(
    defineProps<{
        show?: boolean;
    }>(),
    {
        show: false,
    },
);

const route = useRoute();

const postId = ref<number | null>(null);

const post = ref<Post | null>(null);

const comments = ref<Array<Comment> | null>(null);

const postsStore = usePostsStore();

watch(postId, (newValue, oldValue) => {
    if (postId.value && postsStore.post?.id != postId.value) {
        postApi.get(postId.value).then((res) => {
            console.log(res);
            if (res.status === 200) post.value = res.data;
        });
    } else {
        post.value = postsStore.post;
    }
});

const getComments = () => {
    if (postId.value) {
        commentApi.getByPostId(postId.value).then((res: AxiosResponse) => {
            if (res.status == 200) comments.value = res.data;
        });
    }
};

onMounted(() => {
    if (route.query?.id) {
        postId.value = Number(route.query.id);
        getComments();
    }
});
</script>
