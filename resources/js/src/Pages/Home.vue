<template>
    <h1 class="font-bold text-xl uppercase">Home Page</h1>
    <p>Latest posts</p>
    <div class="space-y-4 mt-4 pb-8">
        <div v-if="posts.length">
            <infinite-scroll-container @load="loadPosts">
                <div class="space-y-4">
                    <PostComponent v-for="post in posts" :post="post" />
                </div>
            </infinite-scroll-container>
        </div>
        <v-card rounded="lg" theme="dark" v-else>
            <div class="space-y-4">
                <v-col v-for="i in 5">
                    <v-skeleton-loader
                        :loading="true"
                        type="image, list-item-two-line"
                    >
                    </v-skeleton-loader>
                </v-col>
            </div>
        </v-card>
    </div>
</template>
<script setup>
import { fetchWrapper } from "@/utils/fetch-wrapper.ts";
import { onMounted, ref } from "vue";
import InfiniteScrollContainer from "@/Components/Feed/InfiniteScrollContainer.vue";
import PostComponent from "@/Components/Post/PostComponent.vue";

const posts = ref([]);

const currentPage = ref(1);
const isEndOfFeed = ref(false);
const isLoading = ref(false);

const loadPosts = () => {
    if (!isEndOfFeed.value && !isLoading.value) {
        isLoading.value = true;
        fetchWrapper
            .get(`/api/posts?page=${currentPage.value}&sorting=new`, {})
            .then((res) => {
                console.log("res", res);
                if (res.data.length > 0) {
                    res.data.forEach((post) => {
                        posts.value.push(post);
                    });
                    currentPage.value += 1;
                    isLoading.value = false;
                } else {
                    isEndOfFeed.value = true;
                }
            });
    }
};

onMounted(() => {
    loadPosts();
});
</script>
