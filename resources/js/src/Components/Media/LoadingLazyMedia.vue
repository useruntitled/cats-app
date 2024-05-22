<template>
    <div class="flex items-center justify-center">
        <div class="absolute z-10 w-20 h-20">
            <CircleLoader />
        </div>
        <div class="brightness-[0.4]">
            <LazyMedia
                class="relative"
                :media="mediaForm"
                :width="props.width"
                :height="props.height"
                :rounded="props.rounded"
            />
        </div>
    </div>
</template>
<script setup lang="ts">
import { computed } from "vue";
import LazyMedia from "@/Components/Media/LazyMedia.vue";
import CircleLoader from "@/Components/Loaders/CircleLoader.vue";

const props = withDefaults(
    defineProps<{
        preview: string;
        isLoaded?: boolean;
        width?: string | number;
        height?: string | number;
        rounded?: string;
    }>(),
    {
        isLoaded: false,
    },
);

const isVideo = computed(() => {
    return props.preview.includes("video");
});

const isGif = computed(() => {
    return props.preview.includes("image/gif");
});

const mediaForm = computed(() => {
    const data = {
        format: "",
        width: "",
        height: "",
        href: "",
        uuid: "",
        base64_preview: props.preview,
        is_video: isVideo.value,
    };
    data.format = isGif.value ? "gif" : isVideo.value ? "mp4" : "jpeg";
    console.log(data);
    return data;
});
</script>
