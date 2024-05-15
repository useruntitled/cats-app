<template></template>
<script setup lang="ts">
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/auth.store.ts";
import router from "@/router/router.ts";

onMounted(() => {
    useAuthStore().logout();
    router.back();
});
</script>
