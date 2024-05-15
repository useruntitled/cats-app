<template>
    <!--  <div class="bg-secondary bg-opacity-50"></div>-->
    <div class="relative">
        <div @click="open = !open" class="px-4">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div
            v-show="open"
            class="fixed inset-0 z-40"
            @click="open = false"
        ></div>

        <Transition
            enter-active-class="transition ease-out duration-0"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-0"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-[100] mt-2 rounded-xl"
                :class="[widthClass, alignmentClasses]"
                style="display: none"
                @click="open = false"
            >
                <div
                    class="rounded-lg px-0 mx-0 text-center ring-1 ring-black ring-opacity-5 bg-opacity-50"
                    :class="contentClasses"
                >
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, provide } from "vue";

const props = defineProps({
    align: {
        type: String,
        default: "right",
    },
    width: {
        type: String,
        default: "48",
    },
    contentClasses: {
        type: String,
        default: "py-1 px-4 dark:bg-secondary",
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === "Escape") {
        open.value = false;
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

const widthClass = computed(() => {
    return {
        auto: `w-[${props.width}rem]`,
        200: "w-[200px]",
        300: "w-[300px]",
        350: "w-[350px]",
        400: "w-[400px]",
        48: "w-48",
        20: "w-20",
        15: "w-15",
    } as object;
});

const alignmentClasses = computed(() => {
    if (props.align === "left") {
        return "origin-top-left left-0";
    } else if (props.align === "right") {
        return "origin-top-right right-0";
    } else {
        return "origin-top";
    }
});

const open = ref(false);
</script>
