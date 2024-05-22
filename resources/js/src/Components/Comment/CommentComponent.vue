<template>
    <div class="shadow-glow px-4 py-2 rounded-lg space-y-2">
        <header>
            <div class="flex items-center justify-between opacity-50 text-sm">
                <span>#{{ props.comment.id }}</span>
                <span v-show="props.comment.reply_id">
                    This is a reply to: #{{ props.comment.reply_id }}
                </span>
            </div>
            <UserComponent :user="comment.author" />
        </header>
        <section>
            <p v-html="comment.text" />
        </section>
        <footer>
            <div class="flex justify-between">
                <div v-if="!repliesIsExpanded && comment.replies?.length">
                    <button
                        @click="repliesIsExpanded = true"
                        class="opacity-80"
                    >
                        Show replies
                    </button>
                </div>
                <button
                    @click="addReplyIsExpanded = true"
                    v-show="!addReplyIsExpanded"
                    class="opacity-80"
                >
                    Add a reply
                </button>
            </div>
            <div class="block" v-show="addReplyIsExpanded">
                <CommentInput
                    @submit="
                        (data) =>
                            emit('submit', {
                                ...data,
                                comment_id: props.comment.id,
                                reply_id: props.comment.id,
                            })
                    "
                />
                <button @click="addReplyIsExpanded = false" class="mt-4">
                    Collapse
                </button>
            </div>
        </footer>
    </div>

    <div v-if="repliesIsExpanded" class="ms-4">
        <CommentComponent
            @submit="
                (data) =>
                    emit('submit', {
                        ...data,
                        comment_id: props.comment.id,
                        reply_id: data.comment_id ?? props.comment.id,
                    })
            "
            :comment="reply as Comment"
            v-for="reply in comment.replies"
            :key="reply?.id"
        />
    </div>
</template>
<script setup lang="ts">
import { Comment } from "@/types";
import UserComponent from "@/Components/User/UserComponent.vue";
import { ref } from "vue";
import CommentInput from "@/Components/Comment/CommentInput.vue";

const emit = defineEmits(["submit"]);

const repliesIsExpanded = ref<boolean>(false);

const addReplyIsExpanded = ref<boolean>(false);

const props = defineProps<{
    comment: Comment;
}>();
</script>
