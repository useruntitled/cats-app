<template>
    <button
        @click="emit('click')"
        class="px-4 dark:bg-secondary border-gray-200 inline-block py-3 dark:rounded-lg rounded-lg shadow-glow hover:brightness-[1.5]"
    >
        <slot />
    </button>
</template>
<script setup>
const emit = defineEmits(["click"]);
</script>
