<template>
    <div ref="container" @scroll="handleScroll($event)">
        <slot></slot>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted, computed, onUnmounted } from "vue";

const container = ref(null);

const diff = ref(2000);

const handleScroll = () => {
    if (
        document.documentElement.scrollTop >=
        container.value?.scrollHeight - diff.value
    ) {
        emit("load");
    }
};

const interval = ref(null);

const containerTop = computed(() => {
    if (container.value.scrollTop == document.documentElement.scrollTop) {
        return Math.max(
            window.pageYOffset || 0,
            document.documentElement.scrollTop,
        );
    }
    return (
        container.value.getBoundingClientRect().top +
        Math.max(window.pageYOffset || 0, document.documentElement.scrollTop)
    );
});

onMounted(() => {
    handleScroll();
    interval.value = setInterval(() => {
        if (document.documentElement.scrollTop >= containerTop.value) {
            handleScroll();
        }
    }, 200);
});

onUnmounted(() => clearInterval(interval.value));
const emit = defineEmits(["load"]);
</script>
