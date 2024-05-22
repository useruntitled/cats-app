<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-400">
            <div
                v-show="show"
                class="fixed inset-0 overflow-y-auto xs:px-0 px-4 py-6 z-[49] dark:text-white max-w-2xl mx-auto noscrollbar"
            >
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-show="show"
                        class="fixed inset-0 transform transition-all backdrop-blur-md bg-white dark:bg-secondary opacity-50 hover:cursor-pointer"
                        @click="close"
                    >
                        <div class="absolute inset-0 opacity-75" />
                    </div>
                </Transition>

                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="show"
                        class="min-h-64 rounded-xl shadow-glowMD transform transition-all sm:w-full sm:mx-auto bg-white xl:px-4 xl:py-4 dark:bg-secondary backdrop-blur-sm bg-opacity-80 dark:bg-opacity-90"
                        :class="[maxWidthClass]"
                    >
                        <slot v-if="show" />
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
<script setup lang="ts">
import { computed, onMounted, onUnmounted, watch } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "2xl",
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["close"]);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = null;
        }
    },
);

// const closeModal = inject("closeModal");

const close = () => {
    if (props.closeable) {
        // closeModal();
        emit("close");
    }
};

const closeOnEscape = (e) => {
    if (e.key === "Escape" && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        sm: "sm:max-w-sm",
        md: "sm:max-w-md",
        lg: "sm:max-w-lg",
        xl: "sm:max-w-xl",
        "2xl": "sm:max-w-2xl",
    } as object;
});
</script>
<style scoped>
/* хром, сафари */
.noscrollbar::-webkit-scrollbar {
    width: 0;
}

/* ie 10+ */
.noscrollbar {
    -ms-overflow-style: none;
}

/* фф (свойство больше не работает, других способов тоже нет)*/
.noscrollbar {
    overflow: -moz-scrollbars-none;
}
</style>
