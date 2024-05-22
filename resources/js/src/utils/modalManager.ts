import router from "@/router/router.ts";
import { useRoute } from "vue-router";

type Action = "open" | "close";

const getPath = () => {
    console.log(window.location.pathname);
    return window.location.pathname;
};

export const modalManager = {
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
    openByQuery: (query: string): void => {
        router.push(getPath() + `?modal=${query}`);
    },
    openProfileEdit: (): void => {
        router.push(getPath() + "?modal=profile-edit");
    },
    openEditor: (): void => {
        router.push(getPath() + "?modal=editor");
    },
    openPost: (id: number): void => {
        router.push(getPath() + `?modal=post&id=${id}`);
    },
    getOpenPost: (id: number) => {
        return getPath() + `?modal=post&id=${id}`;
    },
};
