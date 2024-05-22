<template>
    <div class="flex justify-between items-end space-x-4">
        <div
            contenteditable="true"
            class="appearance-none w-full h-full focus:ring-none focus:outline-none border-b-2 border-b-stone-600 focus:border-b-stone-100"
            :class="placeholderClass"
            @input="handleInput"
            @paste.prevent="handlePaste"
            ref="input"
        ></div>
        <primary-button class="text-sm" @click="onSubmit">
            Send
        </primary-button>
    </div>
</template>
<script setup lang="ts">
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { computed, ref } from "vue";

const emit = defineEmits(["submit"]);

const input = ref<HTMLElement | null>(null);

const content = ref<string | null>(null);

const handleInput = (e: Event) => {
    if (input.value) {
        content.value = input.value.innerHTML;
    }
};

const handlePaste = (e: ClipboardEvent) => {
    if (e.clipboardData) {
        const text = e.clipboardData.getData("text/plain");
        document.execCommand("insertText", false, text);
    }
};

const onSubmit = () => {
    emit("submit", { text: content.value });
};

const placeholderClass = computed(() => {
    if (!content?.value?.length) {
        return "before:content-['Your_comment_here'] text-stone-500";
    }
    return "";
});
</script>
