<template>
    <h1 class="font-bold text-xl">Login</h1>
    <div>
        <input
            v-model="form.email"
            type="email"
            placeholder="email"
            name="email"
        />
        <input
            v-model="form.password"
            type="password"
            placeholder="password"
            name="password"
        />
    </div>
    <div class="text-xl font-bold my-2">
        <primary-button @click="onSubmit">Login</primary-button>
    </div>
    <div class="mt-2">
        <app-router-link :to="{ name: 'register' }"
            >-> Register
        </app-router-link>
    </div>
</template>
<script setup>
import { useAuthStore } from "@/stores/auth.store.ts";
import AppRouterLink from "@/Components/AppRouterLink.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

const form = {
    email: null,
    password: null,
};

function onSubmit() {
    const authStore = useAuthStore();
    const { email, password } = form;

    return authStore.login(email, password);
}
</script>
