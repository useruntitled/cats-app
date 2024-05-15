<template>
    <h1 class="font-bold text-lg">Register</h1>
    <div>
        <input
            v-model="form.name"
            type="text"
            placeholder="name"
            name="name"
            class="dark:text-black"
        />
        <input
            v-model="form.email"
            type="email"
            placeholder="email"
            name="email"
            class="dark:text-black"
        />
        <input
            v-model="form.password"
            type="password"
            placeholder="password"
            name="password"
            class="dark:text-black"
        />
        <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="password again"
            name="password_confirmation"
            class="dark:text-black"
        />
    </div>
    <div class="font-bold text-xl mt-2">
        <primary-button @click="onSubmit">Register</primary-button>
    </div>
    <div class="mt-2">
        <app-router-link :to="{ name: 'login' }">-> Login </app-router-link>
    </div>
</template>
<script setup lang="ts">
import { fetchWrapper } from "@/utils/fetch-wrapper";
import router from "@/router/router";
import AppRouterLink from "@/Components/AppRouterLink.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
const form = {
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
};

const onSubmit = () => {
    fetchWrapper.post("/api/register", form).then((res) => {
        if (res.status === 201) {
            router.push({ name: "login" });
        }
    });
};
</script>
