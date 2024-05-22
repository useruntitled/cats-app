<template>
    <modal-component :show="props.show" @close="emit('close')">
        <modal-template @close="emit('close')">
            <template #header> Editor Modal </template>
            <template #body>
                <PrimaryInput
                    v-model="title"
                    placeholder="title"
                    @input="handleInput"
                />
                <div v-if="!media && !mediaIsLoading">
                    <FilepondComponent @input="handleFile" />
                </div>
                <div v-if="media && !mediaIsLoading">
                    <button class="cursor-pointer w-full" @click="media = null">
                        <!--                        <LazyMedia-->
                        <!--                            :media="media"-->
                        <!--                            rounded="xl"-->
                        <!--                            height="100%"-->
                        <!--                            width="100%"-->
                        <!--                        />-->
                        <FluidLazyMedia
                            :media="media"
                            rounded="xl"
                            max-height="800"
                        />
                    </button>
                </div>
                <div v-if="mediaIsLoading" class="w-full h-full">
                    <LoadingLazyMedia
                        :preview="mediaPreview as string"
                        rounded="xl"
                        height="100%"
                        width="100%"
                    />
                </div>
            </template>
            <template #footer>
                <primary-button
                    class="w-full text-xl font-bold"
                    @click="publish"
                >
                    Publish
                </primary-button>
            </template>
        </modal-template>
    </modal-component>
</template>
<script setup lang="ts">
import ModalComponent from "@/Components/Modals/ModalComponent.vue";
import ModalTemplate from "@/Components/Modals/Templates/ModalTemplate.vue";
import PrimaryInput from "@/Components/Inputs/PrimaryInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import FilepondComponent from "@/Components/Inputs/FilepondComponent.vue";
import { ref } from "vue";
import { postApi } from "@/api/postApi.ts";
import { AxiosResponse } from "axios";
import { AxiosErrorResponse } from "@/utils/fetch-wrapper.ts";
import { mediaApi } from "@/api/mediaApi.ts";
import { Media, Post } from "@/types";
import LazyMedia from "@/Components/Media/LazyMedia.vue";
import LoadingLazyMedia from "@/Components/Media/LoadingLazyMedia.vue";
import { modalManager } from "@/utils/modalManager.ts";
import FluidLazyMedia from "@/Components/Media/FluidLazyMedia.vue";
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

const title = ref<string | null>(null);

const postIsCreated = ref<boolean>(false);

const media = ref<Media | null>(null);
const mediaIsLoading = ref<boolean>(false);
const mediaPreview = ref<string | null>(null);

const post = ref<Post | null>(null);

const messagesStore = useMessagesStore();

const handleInput = () => {};

const handleFile = async (data: { file: File; base64: string }) => {
    if (!postIsCreated.value) {
        await postApi
            .store({
                title: title.value ?? "",
            })
            .then((res): AxiosResponse | void => {
                console.log(res);
                if (res.status === 201) {
                    postIsCreated.value = true;
                    post.value = res.data;
                }
            });
    }
    mediaIsLoading.value = true;
    mediaPreview.value = data.base64;
    mediaApi
        .upload(data.file)
        .catch((res) => {
            console.log(res);
            if (res.response) {
                messagesStore.addErrors(res);
            }
        })
        .then((res: AxiosResponse | void) => {
            console.log(res);
            if (res && res.status === 201) {
                media.value = res.data;
                mediaIsLoading.value = false;
            }
        });
};

const publish = () => {
    postApi
        .publish({
            id: Number(post.value?.id ?? 0),
            title: String(title.value ?? null),
            media: media.value as Media,
        })
        .catch((res: AxiosErrorResponse) => {
            console.log(res);
            messagesStore.addErrors(res);
        })
        .then((res: AxiosResponse | void) => {
            console.log(res);
            if (res && res.status === 200 && post.value) {
                modalManager.openPost(post.value.id);
            }
        });
};
</script>
