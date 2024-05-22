<template>
    <input ref="filepond" type="file" class="hidden" @input="handleFile" />
    <button @click="onClick" class="block w-full">
        <IconPhotoScan />
    </button>
</template>
<script setup lang="ts">
import { IconPhotoScan } from "@tabler/icons-vue";
import { ref } from "vue";
import { fileHandler } from "@/utils/fileHandler.ts";

const emit = defineEmits(["input"]);

const filepond = ref<HTMLInputElement | null>(null);

const onClick = () => {
    if (filepond.value) filepond.value.click();
};

const handleFile = (
    e: InputEvent & { target: HTMLInputElement & EventTarget },
) => {
    if (e.target.files && e.target?.files.length == 1) {
        const file = e.target.files[0];
        const data = {
            file: file,
            base64: "",
        };

        fileHandler.handle(file, (base64: string) => {
            data.base64 = base64;
            emit("input", data);
        });
    }
};
</script>
