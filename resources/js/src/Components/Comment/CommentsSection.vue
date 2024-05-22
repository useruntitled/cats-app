<template>
    <section class="mb-4">
        <CommentInput @submit="storeComment" />
    </section>
    <div v-if="comments" class="space-y-4">
        <CommentComponent
            @submit="storeComment"
            :comment="comment"
            v-for="comment in comments"
            :key="comment.id"
        />
    </div>
    <div v-else>
        <v-skeleton-loader type="article" rounded="xl" theme="dark">
        </v-skeleton-loader>
    </div>
</template>
<script setup lang="ts">
import CommentComponent from "@/Components/Comment/CommentComponent.vue";
import CommentInput from "@/Components/Comment/CommentInput.vue";
import { commentApi } from "@/api/commentApi.ts";
import { AxiosErrorResponse } from "@/utils/fetch-wrapper.ts";
import { useMessagesStore } from "@/stores/messages.store.ts";
import { AxiosResponse } from "axios";
import { Comment } from "@/types";

const emit = defineEmits(["refreshComments", "updateComment"]);

const props = defineProps<{
    comments: Comment[];
    postId: Number;
}>();

const messagesStore = useMessagesStore();

const storeComment = (data: {
    text: string;
    comment_id?: number;
    reply_id?: number;
}) => {
    commentApi
        .store(
            Number(props.postId),
            data.comment_id ?? null,
            data.reply_id ?? null,
            data.text,
        )
        .catch((res: AxiosErrorResponse) => {
            console.log(res);
            messagesStore.addErrors(res);
        })
        .then((res: AxiosResponse | void) => {
            console.log(res);
            if (res && res.status == 201) {
                if (res.data.comment_id == null) {
                    emit("refreshComments", [
                        res.data as Comment,
                        ...props.comments,
                    ]);
                } else {
                    const comments = [...props.comments];
                    const updatedComment: Comment | undefined = comments.find(
                        (obj) => obj.id == res.data.comment_id,
                    );
                    if (updatedComment && updatedComment.replies)
                        updatedComment.replies.unshift(res.data);
                    emit("refreshComments", comments);
                }
            }
        });
};
</script>
