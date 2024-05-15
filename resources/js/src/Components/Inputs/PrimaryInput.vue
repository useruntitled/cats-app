<template>
    <input
        class="w-full dark:bg-secondary dark:text-white dark:placeholder:text-zinc-400 border-b-2 border-zinc-700 focus:border-zinc-500 focus:ring-0 focus:outline-0"
        :placeholder="props.placeholder"
        :type="props.type"
        v-model="model"
    />
</template>
<script setup lang="ts">
const model = defineModel();

const props = withDefaults(
    defineProps<{
        placeholder?: string;
        type?: string;
        value?: string;
    }>(),
    {
        type: "text",
    },
);

model.value = props.value;
</script>
