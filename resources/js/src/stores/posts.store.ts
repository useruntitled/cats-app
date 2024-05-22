import { defineStore, StoreDefinition } from "pinia";
import { Post } from "@/types";

type StateType = {
    post: Post | null;
};

export const usePostsStore: StoreDefinition = defineStore({
    id: "posts",
    state: () =>
        ({
            post: null,
        }) as StateType,
    actions: {
        set(post: Post) {
            this.post = post;
        },
    },
});
