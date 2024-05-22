<template>
    <modal-component :show="props.show" @close="emit('close')">
        <modal-template @close="emit('close')">
            <template #header>
                <span>Auth Modal</span>
                <span>
                    <primary-button @click="currentForm = nextForm">
                        -> {{ nextForm }}
                    </primary-button>
                </span>
            </template>
            <template #body v-if="currentForm === 'login'">
                <PrimaryInput
                    v-model="loginForm.email"
                    type="email"
                    placeholder="email"
                />
                <PrimaryInput
                    v-model="loginForm.password"
                    type="password"
                    placeholder="password"
                />
            </template>
            <template #body v-else>
                <PrimaryInput
                    v-model="registerForm.name"
                    type="text"
                    placeholder="name"
                />
                <PrimaryInput
                    v-model="registerForm.email"
                    type="email"
                    placeholder="email"
                />
                <PrimaryInput
                    v-model="registerForm.password"
                    type="password"
                    placeholder="password"
                />
                <PrimaryInput
                    v-model="registerForm.password_confirmation"
                    type="password"
                    placeholder="password again"
                />
            </template>
            <template #footer v-if="currentForm === 'login'">
                <primary-button @click="login" class="w-full font-bold text-xl">
                    Login
                </primary-button>
            </template>
            <template #footer v-else>
                <primary-button
                    @click="register"
                    class="w-full font-bold text-xl"
                >
                    Register
                </primary-button>
            </template>
        </modal-template>
    </modal-component>
</template>
<script setup lang="ts">
import ModalComponent from "@/Components/Modals/ModalComponent.vue";
import PrimaryInput from "@/Components/Inputs/PrimaryInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { computed, ref } from "vue";
import { AxiosErrorResponse, fetchWrapper } from "@/utils/fetch-wrapper.ts";
import { useAuthStore } from "@/stores/auth.store.ts";
import ModalTemplate from "@/Components/Modals/Templates/ModalTemplate.vue";
import { AxiosResponse } from "axios";
import { useMessagesStore } from "@/stores/messages.store.ts";

const emit = defineEmits(["close"]);

const props = withDefaults(
    defineProps<{
        show?: boolean;
    }>(),
    {
        show: false,
    },
);

const currentForm = ref("login");

const nextForm = computed(() => {
    return currentForm.value === "login" ? "register" : "login";
});

const loginForm = {
    email: null,
    password: null,
};

const registerForm = {
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
};

const authStore = useAuthStore();
const messagesStore = useMessagesStore();
const login = () => {
    authStore
        .login(loginForm["email"], loginForm["password"])
        .catch((res: AxiosErrorResponse) => {
            messagesStore.addErrors(res);
        })
        .then((res: AxiosResponse) => {
            if (res.status === 200) {
                emit("close");
            }
        });
};

const register = () => {
    fetchWrapper
        .post("/api/register", registerForm)
        .catch((res: AxiosErrorResponse) => {
            messagesStore.addErrors(res);
        })
        .then((res: AxiosResponse | void) => {
            if (res.status === 201) {
                console.log(res);
                authStore
                    .login(registerForm["email"], registerForm["password"])

                    .then(() => {
                        emit("close");
                    });
            }
        });
};
</script>
