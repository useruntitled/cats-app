<template>
    <router-link :to="route(props.to)">
        <slot />
    </router-link>
</template>
<script setup lang="ts">
import { route } from "@/router/router";
import type { TRouteTo } from "@/router/router";

const props = defineProps<{
    to: TRouteTo;
}>();
</script>
