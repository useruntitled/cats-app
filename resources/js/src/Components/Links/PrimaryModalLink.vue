<template>
    <primary-button @click="onClick">
        <slot />
    </primary-button>
</template>
<script setup lang="ts">
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const props = defineProps<{
    method: Function;
}>();

const onClick = () => {
    props.method();
};
</script>
