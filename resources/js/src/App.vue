<template>
    <!--    <AuthModal :show="showModal" @close="closeModal" />-->
    <component
        :is="modalsTypes[modalType]"
        :show="showModal"
        @close="closeModal"
    />

    <div
        class="dark:bg-black bg-white dark:text-white transition-all duration-400"
    >
        <div class="min-h-screen max-w-6xl mx-auto dark:text-white">
            <div class="max-w-6xl">
                <MessagesComponent />
            </div>
            <HeaderComponent />
            <div class="mt-5 w-full min-h-screen">
                <router-view />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref, watch } from "vue";
import { fetchWrapper } from "@/utils/fetch-wrapper.ts";
import HeaderComponent from "@/partials/HeaderComponent.vue";
import AuthModal from "@/Components/Modals/AuthModal.vue";
import { useThemeStore } from "@/stores/theme.store.ts";
import { useRoute } from "vue-router";
import { modalManager } from "@/utils/modalManager.ts";
import EditProfileModal from "@/Components/Modals/EditProfileModal.vue";
import MessagesComponent from "@/Components/Messages/MessagesComponent.vue";
import { useAuthStore } from "@/stores/auth.store.ts";

const route = useRoute();

const auth = useAuthStore();

const modalsTypes: { [key: string]: any } = {
    auth: AuthModal,
    "profile-edit": EditProfileModal,
};

const showModal = ref(false);
const modalType = computed(() => {
    return route.query.modal;
});
const closeModal = () => {
    showModal.value = false;
    modalManager.close();
};

watch(route, () => {
    if (route.query?.modal != null) {
        console.log(route.query.modal);
        showModal.value =
            !!modalsTypes[route.query.modal as keyof typeof modalsTypes];
    }
});

onMounted(async () => {
    defineTheme();

    fetchWrapper.post("/api/me", {}).then((res) => {
        auth.auth.user = res.data;
    });
});

const defineTheme = () => {
    const theme = useThemeStore()?.theme;
    console.log(theme);
    if (
        theme === "dark" ||
        (theme == null &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        document.documentElement.classList.add("dark");
        useThemeStore().set("dark");
    }
};
</script>
