<template>
    <modal-component :show="show" @close="emit('close')">
        <modal-template @close="emit('close')">
            <template #header> Edit Profile Modal </template>
            <template #body>
                <div
                    class="flex flex-col items-center justify-between space-y-5"
                >
                    <div v-if="!auth.auth.user.has_avatar && !avatarIsLoading">
                        <AvatarFilepond @input="handleAvatar" />
                    </div>
                    <div v-if="avatarIsLoading" class="cursor-pointer">
                        <LoadingLazyMedia
                            width="200"
                            height="200"
                            rounded="full"
                            @click="deleteAvatar"
                            :preview="avatarPreview"
                            :isLoaded="auth.auth.user.has_avatar"
                        />
                    </div>
                    <div
                        v-if="auth.auth.user.has_avatar"
                        class="cursor-pointer"
                        @click="deleteAvatar"
                    >
                        <LazyMedia
                            :media="auth.auth.user.avatar"
                            rounded="full"
                            width="200"
                            height="200"
                            class="border-4 dark:border-stone-800"
                        />
                    </div>
                    <div class="w-full">
                        <PrimaryInput
                            placeholder="name"
                            :value="auth.auth.user.name"
                        />
                    </div>
                </div>
            </template>
            <template #footer>
                <primary-button class="w-full font-bold text-xl">
                    Save
                </primary-button>
            </template>
        </modal-template>
    </modal-component>
</template>
<script setup lang="ts">
import ModalComponent from "@/Components/Modals/ModalComponent.vue";
import PrimaryInput from "@/Components/Inputs/PrimaryInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import ModalTemplate from "@/Components/Modals/Templates/ModalTemplate.vue";
import { useAuthStore } from "@/stores/auth.store.ts";
import AvatarFilepond from "@/Components/Inputs/Media/AvatarFilepond.vue";
import { profileApi } from "@/api/profileApi.ts";
import axios, { AxiosResponse } from "axios";
import { mediaApi } from "@/api/mediaApi.ts";
import { ref } from "vue";
import LazyMedia from "@/Components/Media/LazyMedia.vue";
import { AxiosErrorResponse } from "@/utils/fetch-wrapper.ts";
import { Media } from "@/types";
import LoadingLazyMedia from "@/Components/Media/LoadingLazyMedia.vue";
import CircleLoader from "@/Components/Loaders/CircleLoader.vue";

const auth = useAuthStore();

const emit = defineEmits(["close"]);
const props = withDefaults(
    defineProps<{
        show?: boolean;
    }>(),
    {
        show: false,
    },
);

const avatarIsLoading = ref(false);

const loadedAvatar = ref<Media | null>(null);
const avatarPreview = ref<string | null>(null);

const handleAvatar = async (data: { file: File; base64: string }) => {
    console.log(data);

    avatarIsLoading.value = true;
    avatarPreview.value = data.base64;

    await mediaApi
        .upload(data.file)
        .catch((res: AxiosErrorResponse) => {
            console.log(res);
        })
        .then((res: AxiosResponse) => {
            if (res.status === 201) {
                console.log(res.data);
                loadedAvatar.value = res.data as Media;
                profileApi
                    .uploadAvatar(loadedAvatar.value.uuid)
                    .catch((res: AxiosErrorResponse) => {
                        console.log(res);
                    })
                    .then((res: AxiosResponse) => {
                        console.log(res);
                        auth.setAvatar(loadedAvatar.value);
                        avatarIsLoading.value = false;
                    });
            }
        });
};

const deleteAvatar = () => {
    if (auth.auth.user.has_avatar) {
        profileApi.deleteAvatar(auth.auth.user.avatar.uuid).then((res) => {
            auth.unsetAvatar();
            console.log(res);
        });
    }
    loadedAvatar.value = null;
    avatarIsLoading.value = false;
};
</script>
