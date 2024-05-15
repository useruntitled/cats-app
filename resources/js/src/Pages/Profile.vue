<template>
    <h1 class="font-bold text-xl uppercase">Profile Page</h1>
    <div class="mt-4 flex justify-between items-center">
        <div class="text-2xl font-bold">
            {{ user ? user.name : "" }}
        </div>
        <div v-if="isMe">
            <primary-button @click="openModal">
                <IconSettings class="w-6 h-6 stroke-2" />
            </primary-button>
        </div>
    </div>
</template>
<script setup lang="ts">
import { IconSettings } from "@tabler/icons-vue";
import { computed, onMounted, ref, watch } from "vue";
import { profileApi } from "@/api/profileApi.ts";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth.store.ts";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import { modalManager } from "@/utils/modalManager.ts";

const route = useRoute();

const user = ref(null);

const openModal = () => {
    modalManager.openProfileEdit();
};

watch(route, (newValue, oldValue) => {
    getUser();
});

onMounted(() => {
    getUser();
});

const getUser = () => {
    profileApi.get(Number(route.params.id), (res) => {
        if (res.status == 200) {
            console.log(res);
            user.value = res.data;
        }
    });
};

const auth = useAuthStore();

const isMe = computed(() => {
    if (auth.check && user.value) {
        return auth.auth.user.id == user.value.id;
    }
    return false;
});
</script>
