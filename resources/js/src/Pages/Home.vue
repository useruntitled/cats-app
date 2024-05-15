<template>
    <h1 class="font-bold text-xl uppercase">Home Page</h1>
    <p>Latest posts</p>
    <div class="space-y-4 mt-4">
        <!--        <VSkeletonLoader-->
        <!--            theme="dark"-->
        <!--            color="dark"-->
        <!--            type="card-avatar"-->
        <!--            v-for="i in 5"-->
        <!--        />-->
        <div v-if="posts.length">
            <infinite-scroll-container @load="loadPosts">
                <div class="space-y-4">
                    <Post v-for="post in posts" :post="post" />
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
import Post from "@/Components/Post/Post.vue";
import InfiniteScrollContainer from "@/Components/Feed/InfiniteScrollContainer.vue";

const posts = ref([]);

const currentPage = ref(1);
const isEndOfFeed = ref(false);

const loadPosts = () => {
    if (!isEndOfFeed.value) {
        fetchWrapper
            .get(`/api/posts/latest?page=${currentPage.value}`, {})
            .then((res) => {
                console.log("res", res);
                if (res.data.length > 0) {
                    res.data.forEach((post) => {
                        posts.value.push(post);
                    });
                    currentPage.value += 1;
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
