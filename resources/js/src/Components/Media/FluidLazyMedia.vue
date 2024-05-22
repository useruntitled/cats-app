<template>
    <!--    <div class="w-[45px] h-[45px] border-gray-100"></div>-->
    <div class="overflow-hidden" ref="block">
        <div
            class="relative flex justify-center overflow-hidden"
            :style="heightStyle"
        >
            <img
                class="absolute w-full h-full z-[2] opacity-80 shadow-inner top-0"
                :src="media.base64_preview"
                :class="[previewRoundedClass, props.class, borderClass]"
                alt=""
            />

            <img
                v-if="!isVideo"
                class="absolute object-contain top-0 bottom-0 mx-auto z-[4]"
                @load="isLoaded = true"
                :src="src"
                :class="[roundedClass, props.class, borderClass, showClass]"
                :style="[heightStyle, widthStyle]"
                :type="`image/${media.format}`"
                alt=""
                loading="lazy"
            />
            <video
                v-else
                class="absolute backdrop-blur-3xl object-contain top-0 bottom-0 mx-auto z-[4]"
                loop
                autoplay
                muted
                @loadeddata="isLoaded = true"
                :class="[roundedClass, props.class, borderClass, showClass]"
                :style="[heightStyle, widthStyle]"
            >
                <source :src="media.href" type="video/mp4" />
            </video>
        </div>
    </div>
</template>
<script setup lang="ts">
import { computed, ref } from "vue";
import { Media } from "@/types";

const props = withDefaults(
    defineProps<{
        media: Media;
        rounded?: string;
        class?: string;
        border?: string | number;
        maxHeight?: string | number;
        maxWidth?: string | number;
    }>(),
    {
        rounded: "none",
        border: 0,
    },
);

const block = ref<HTMLElement | null>();

const showClass = computed(() => {
    if (!isLoaded.value) return "hidden";
});
const previewRoundedClass = computed(() => {
    return `rounded-${props.rounded}`;
});

const roundedClass = computed(() => {
    if (
        heightStyle.value == `height: auto` ||
        heightStyle.value == `height: ${props.maxHeight}px`
    ) {
        return `rounded-none`;
    }
    return `rounded-${props.rounded}`;
});

const borderClass = computed(() => {
    return `border-[${props.border ?? 0}px] border-gray-100`;
});

const widthStyle = computed(() => {
    return "width: auto";
});

const heightStyle = computed(() => {
    if (props.maxHeight != null && block.value) {
        const mult = Number(props.media.height) * Number(props.media.width);
        const k = mult / block.value.clientWidth;
        const c = Number(props.media.height) / k;
        if (c * Number(props.media.height) <= Number(props.maxHeight)) {
            return `height: ${Number(props.media.height) * c}px`;
        }
        return `height: ${props.maxHeight}px`;
    }
    return "height: auto";
});

const src = computed(() => {
    return isLoaded.value ? props.media.href : props.media.base64_preview;
});

const isLoaded = ref(false);

const isVideo = computed(() => {
    return props.media.is_video;
});
</script>
