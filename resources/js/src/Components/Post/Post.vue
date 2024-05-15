<template>
    <div
        class="w-full py-4 px-5 dark:bg-secondary shadow-glow rounded-lg hover:brightness-[1.5] space-y-2"
    >
        <div>
            <UserComponent :user="post.author" />
        </div>
        <div class="font-bold text-xl">
            {{ post.title }}
        </div>
    </div>
</template>
<script setup>
import UserComponent from "@/Components/User/UserComponent.vue";

const props = defineProps({
    post: {
        required: true,
        type: Object,
    },
});
</script>
