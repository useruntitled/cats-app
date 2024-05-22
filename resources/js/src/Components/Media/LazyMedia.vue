<template>
    <!--    <div class="w-[40px] h-[40px] border-gray-100"></div>-->
    <!--    <div class="w-[90px] h-[90px] border-gray-100 border-[3.5px]"></div>-->
    <div class="relative" :style="[heightStyle]">
        <div class="relative flex justify-center w-full">
            <img
                v-if="!isVideo"
                class="absolute w-full h-full object-cover z-[2] top-0 max-w-none"
                :src="media.base64_preview"
                :class="[roundedClass, props.class, borderClass, props.class]"
                :style="[heightStyle, widthStyle]"
                alt=""
            />
            <video v-else>
                <source :src="media.base64_preview" type="video/mp4" />
            </video>

            <img
                v-if="!isVideo && media.href"
                class="object-cover mx-auto hover:brightness-[1.2] z-[4] max-w-none"
                @load="isLoaded = true"
                :src="media.href"
                :class="[roundedClass, props.class, borderClass, props.class]"
                :style="[heightStyle, widthStyle]"
                alt=""
                loading="lazy"
            />

            <video
                v-if="isVideo && media.href"
                class="backdrop-blur-3xl hover:brightness-[1.2] object-cover mx-auto z-[4] max-w-none"
                loop
                autoplay
                muted
                @loadeddata="isLoaded = true"
                :class="[roundedClass, props.class, borderClass, props.class]"
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
        width?: string | number;
        height?: string | number;
        class?: string | null;
        border?: string | number;
    }>(),
    {
        rounded: "none",
        width: 100,
        height: 150,
        class: null,
        border: 0,
    },
);

const roundedClass = computed(() => {
    return `rounded-${props.rounded}`;
});

const borderClass = computed(() => {
    return `border-[${props.border}px] border-gray-100`;
});

const widthStyle = computed(() => {
    if (props.width.toString().includes("%")) {
        return `width: ${props.width}`;
    }
    return `width: ${props.width}px`;
});

const heightStyle = computed(() => {
    if (props.height.toString().includes("%")) {
        return `height: ${props.height}`;
    }
    return `height: ${props.height}px`;
});

const isLoaded = ref(false);

const isVideo = computed(() => {
    return props.media?.is_video;
});
</script>
