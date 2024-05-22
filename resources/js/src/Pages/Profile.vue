<template>
    <h1 class="font-bold text-xl uppercase">Profile Page</h1>
    <div
        class="mt-4 flex justify-between items-center shadow-glow px-4 py-2 rounded-lg dark:bg-secondary"
    >
        <div class="text-2xl font-bold space-y-2 flex items-center space-x-4">
            <div v-if="user?.has_avatar" class="max-w-min">
                <LazyMedia
                    :media="user.avatar"
                    width="100"
                    height="100"
                    rounded="full"
                    class="border-4 dark:border-stone-800"
                />
            </div>
            <div>
                {{ user ? user.name : "Loading..." }}
            </div>
        </div>
        <div v-if="isMe">
            <primary-button @click="openModal">
                <IconSettings class="w-6 h-6 stroke-2" />
            </primary-button>
        </div>
    </div>
    <div
        class="mt-4 shadow-glow dark:bg-secondary px-4 py-2 rounded-lg space-x-4"
    >
        <button
            class="text-xl"
            :class="{ 'opacity-80': !isPostsSection }"
            @click="isPostsSection = true"
        >
            Posts
        </button>
        <button
            class="text-xl"
            :class="{ 'opacity-80': isPostsSection }"
            @click="isPostsSection = false"
        >
            Comments
        </button>
        <section class="mt-4">
            <div v-show="isLoading">Loading..</div>
            <div v-if="posts && isPostsSection">
                <div class="space-y-4">
                    <infinite-scroll-container @load="load">
                        <PostComponent :post="post" v-for="post in posts" />
                    </infinite-scroll-container>
                </div>
            </div>
            <div v-if="comments && !isPostsSection">
                <infinite-scroll-container @load="load">
                    <div class="space-y-4">
                        <div v-for="comment in comments">
                            <p v-html="comment.text"></p>
                        </div>
                    </div>
                </infinite-scroll-container>
            </div>
        </section>
    </div>
</template>
<script setup lang="ts">
import { IconSettings } from "@tabler/icons-vue";
import { computed, onMounted, ref, watch } from "vue";
import { profileApi } from "@/api/profileApi.ts";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth.store.ts";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { modalManager } from "@/utils/modalManager.ts";
import LazyMedia from "@/Components/Media/LazyMedia.vue";

import { commentApi } from "@/api/commentApi.ts";
import { AxiosResponse } from "axios";
import { Post } from "@/types";
import PostComponent from "@/Components/Post/PostComponent.vue";
import { postApi } from "@/api/postApi.ts";
import CommentComponent from "@/Components/Comment/CommentComponent.vue";
import InfiniteScrollContainer from "@/Components/Feed/InfiniteScrollContainer.vue";

const route = useRoute();

const user = ref(null);
const posts = ref<Array<Post> | []>([]);
const comments = ref<Array<Comment> | []>([]);

const postsPage = ref<number>(1);
const commentsPage = ref<number>(1);
const isEndOfFeed = ref<boolean>(false);
const isLoading = ref<boolean>(false);

const openModal = () => {
    modalManager.openProfileEdit();
};

watch(route, (newValue, oldValue) => {
    getUser();
});

onMounted(() => {
    getUser();
});

const load = () => {
    if (!isEndOfFeed.value && !isLoading.value) {
        if (isPostsSection.value) {
            isLoading.value = true;
            getPosts();
        } else {
            isLoading.value = true;
            getComments();
        }
    }
};

const isPostsSection = ref<boolean>(true);

watch(isPostsSection, () => {
    posts.value = [];
    isEndOfFeed.value = false;
    commentsPage.value = 1;
    postsPage.value = 1;
    comments.value = [];
});

const getUser = () => {
    profileApi.get(Number(route.params.id), (res) => {
        if (res.status == 200) {
            console.log(res);
            user.value = res.data;
        }
    });
};

const getComments = () => {
    commentApi
        .getByUserId(Number(route.params.id), commentsPage.value)
        .then((res: AxiosResponse | void) => {
            if (res) {
                console.log(res);
                commentsPage.value++;
                isLoading.value = false;
                if (!res.data.length) isEndOfFeed.value = true;
                else {
                    res.data.forEach((comment: Comment) => {
                        comments.value.push(comment);
                    });
                }
            }
        });
};

const getPosts = () => {
    postApi
        .getByProfileId(Number(route.params.id), postsPage.value)
        .then((res: AxiosResponse | void) => {
            if (res) {
                console.log(res);
                postsPage.value++;
                isLoading.value = false;
                if (!res.data.length) isEndOfFeed.value = true;
                else {
                    res.data.forEach((post: Post) => {
                        posts.value.push(post);
                    });
                }
            }
        });
};

const auth = useAuthStore();

const isMe = computed(() => {
    if (auth.check && user.value) {
        return auth.auth.user?.id == user.value?.id;
    }
    return false;
});
</script>
