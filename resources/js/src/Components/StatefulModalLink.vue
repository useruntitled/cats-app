<template>
    <div @click="onClick">
        <slot />
    </div>
</template>
<script setup lang="ts">
import router, { TRouteTo } from "@/router/router.ts";
import { useRoute } from "vue-router";
const props = defineProps<{
    func: Function;
    to: string;
}>();

const route = useRoute();

const onClick = () => {
    props.func();
    router.push(props.to);
};
</script>
