<template>
    <h1 class="text-xl font-bold uppercase space-x-4 px-4">
        <div class="flex justify-between">
            <div>
                <slot name="header" />
            </div>
            <div class="cursor-pointer" @click="emit('close')">close</div>
        </div>
    </h1>
    <div class="flex flex-col h-full mb-8">
        <div
            class="mt-6 mb-6 space-y-6 noscrollbar text-lg overflow-x-hidden w-full break-words"
        >
            <slot name="body" />
        </div>
    </div>
    <div class="bottom-0 fixed w-full max-w-[95%] z-10">
        <div class="mt-8 pb-4">
            <slot name="footer" />
        </div>
    </div>
</template>
<script setup lang="ts">
const emit = defineEmits(["close"]);
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
