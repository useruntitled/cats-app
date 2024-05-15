import router from "@/router/router.ts";
import { useRoute } from "vue-router";

type Action = "open" | "close";

const getPath = () => {
    console.log(window.location.pathname);
    return window.location.pathname;
};

export const modalManager: {
    auth: (action: Action) => void;
    close: () => void;
    openProfileEdit: () => void;
} = {
    close: () => {
        router.push(getPath());
    },
    auth: (action: Action): void => {
        if (action === "close") {
            router.push(getPath());
        } else {
            router.push(getPath() + "?modal=auth");
        }
    },
    openProfileEdit: (): void => {
        router.push(getPath() + "?modal=profile-edit");
    },
};
