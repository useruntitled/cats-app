<template>
    <h1 class="text-xl font-bold uppercase space-x-4">
        <slot name="header" />
    </h1>
    <div class="mt-6 space-y-6 text-lg">
        <slot name="body" />
    </div>
    <div class="mt-8">
        <slot name="footer" />
    </div>
</template>
