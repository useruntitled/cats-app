<template>
    <div
        class="max-w-64 inset-y-0 fixed h-min z-50 shadow-sm dark:shadow-secondary"
    >
        <div
            class="p-4 text-white opacity-90 backdrop-blur-3xl shadow-glow dark:bg-secondary max-w-64 h-min mt-2 z-50 px-4 rounded-lg"
            v-for="message in messages"
        >
            {{ message.text }}
        </div>
    </div>
</template>
<script setup lang="ts">
import { onUnmounted, ref } from "vue";
import { useMessagesStore } from "@/stores/messages.store.ts";

const messagesStore = useMessagesStore();

const messages = ref(messagesStore.messages);

onUnmounted(() => {
    messagesStore.reset();
});
</script>
