<template>
    <IconLoader2 class="animate-spin" :class="color" />
</template>
<script setup>
import { IconLoader2 } from "@tabler/icons-vue";

const props = defineProps({
    color: {
        type: String,
        default: "text-stone-200",
    },
});
</script>
