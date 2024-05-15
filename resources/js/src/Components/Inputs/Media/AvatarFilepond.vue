<template>
    <input
        ref="filepond"
        type="file"
        accept="image/*"
        class="hidden"
        @input="handleFile"
    />
    <button @click="onClick">
        <IconPhotoScan :class="sizeClass" stroke="0.5" />
    </button>
</template>
<script setup lang="ts">
import { IconPhotoScan } from "@tabler/icons-vue";
import { computed, ref } from "vue";
import { fileHandler } from "@/utils/fileHandler.ts";

const emit = defineEmits(["input"]);

const filepond = ref(null);

const props = withDefaults(
    defineProps<{
        size?: string;
    }>(),
    {
        size: "200",
    },
);

const sizeClass = computed(() => {
    return `w-[${props.size}px] h-[${props.size}px]`;
});

const onClick = () => {
    filepond.value.click();
};

const handleFile = (e: Event) => {
    if (e.target?.files.length == 1) {
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
