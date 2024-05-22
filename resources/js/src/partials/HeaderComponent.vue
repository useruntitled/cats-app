<template>
    <div class="w-full">
        <div class="flex justify-between items-center mx-1">
            <div class="flex items-center">
                <app-router-link :to="{ name: '/' }">
                    <AppLogo
                        class="w-20 h-20 stroke-black dark:fill-white dark:stroke-white stroke-6"
                    />
                </app-router-link>
            </div>
            <div class="flex space-x-4 items-center">
                <primary-modal-link :method="modalManager.openEditor">
                    Create post
                </primary-modal-link>
                <div v-if="user">
                    <dropdown>
                        <template #trigger>
                            <button class="flex items-center space-x-2">
                                <span class="text-xl font-bold"> Me </span>
                                <span>
                                    <IconChevronDown />
                                </span>
                            </button>
                        </template>
                        <template #content>
                            <div class="text-lg">
                                <p>
                                    <app-router-link
                                        :to="{
                                            name: 'user',
                                            params: { id: user.id },
                                        }"
                                    >
                                        Profile
                                    </app-router-link>
                                </p>
                                <p>
                                    <app-router-link :to="{ name: 'logout' }">
                                        Logout
                                    </app-router-link>
                                </p>
                            </div>
                        </template>
                    </dropdown>
                </div>
                <div v-else>
                    <div class="text-lg font-bold dark:bg-secondary">
                        <primary-button @click="showModal">
                            Login
                        </primary-button>
                    </div>
                </div>
                <div>
                    <!--          <button @click="onThemeChange">{{ themeIcon }}</button>-->
                    <button @click="onThemeChange">
                        <component :is="themeIcon" class="w-12 h-12" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useAuthStore } from "@/stores/auth.store";
import { useThemeStore } from "@/stores/theme.store";
import { computed, nextTick, onMounted, ref, watch } from "vue";
import AppRouterLink from "@/Components/AppRouterLink.vue";
import AppLogo from "@/Components/AppLogo.vue";
import SunIcon from "@/Components/Icons/SunIcon.vue";
import MoonIcon from "@/Components/Icons/MoonIcon.vue";
import Dropdown from "@/Components/Dropdowns/Dropdown.vue";
import IconChevronDown from "@/Components/Icons/IconChewronDown.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { modalManager } from "@/utils/modalManager.ts";
import PrimaryModalLink from "@/Components/Links/PrimaryModalLink.vue";

const showModal = () => {
    modalManager.auth("open");
};

const user = ref(useAuthStore().auth?.user);

watch(useAuthStore(), () => {
    if (useAuthStore().check === true) {
        user.value = useAuthStore().auth.user;
    } else {
        user.value = null;
    }
});

const theme = ref(useThemeStore()?.theme);

const themeIconsTypes = {
    light: SunIcon,
    dark: MoonIcon,
};

const themeIcon = computed(() => {
    if (
        theme.value == "dark" ||
        document.documentElement.classList.contains("dark")
    ) {
        return themeIconsTypes["dark"];
    }
    return themeIconsTypes["light"];
});

onMounted(() => {
    nextTick(() => {
        theme.value = useThemeStore().theme;
    });
});

const onThemeChange = () => {
    useThemeStore().toggle();
    theme.value = useThemeStore()?.theme;
    if (theme.value == "dark") {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
};
</script>
