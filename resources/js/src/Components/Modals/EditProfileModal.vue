<template>
    <modal-component :show="show" @close="emit('close')">
        <modal-template>
            <template #header> Edit Profile Modal </template>
            <template #body>
                <div class="flex items-center justify-between">
                    <div v-if="!auth.auth.user?.has_avatar">
                        <AvatarFilepond @input="handleAvatar" />
                    </div>
                    <div class="w-full">
                        <PrimaryInput
                            placeholder="name"
                            :value="auth.auth.user?.name"
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

const handleAvatar = (data: object) => {
    console.log(data);
    profileApi
        .uploadAvatar(auth.auth.user.id, data.file)
        .catch((res) => {
            console.log(res);
        })
        .then((res) => {
            console.log(res);
        });
};
</script>
