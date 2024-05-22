import { defineStore, StoreDefinition } from "pinia";
import { AxiosErrorResponse } from "@/utils/fetch-wrapper.ts";

type StateType = {
    messages: Array<Object>;
};

export const useMessagesStore: StoreDefinition = defineStore({
    id: "messages",
    state: () =>
        ({
            messages: JSON.parse(localStorage.getItem("messages") ?? "[]"),
        }) as StateType,
    actions: {
        add(message: string) {
            const id = this.messages.length;
            this.messages.push({
                id: id,
                text: message,
            });
            localStorage.setItem("messages", JSON.stringify(this.messages));

            setTimeout(() => {
                this.delete(id);
            }, 5000);
        },
        addErrors(res: AxiosErrorResponse) {
            if (res.response.data.errors) {
                Object.keys(res.response.data.errors).forEach(
                    (error: string) => {
                        res.response.data.errors[error].forEach(
                            (message: string) => {
                                this.add(message);
                            },
                        );
                    },
                );
            }
        },
        delete(id: number) {
            this.messages.splice(
                this.messages.findIndex((obj) => obj.id == id),
                1,
            );
            localStorage.setItem("messages", JSON.stringify(this.messages));
        },
        reset() {
            localStorage.removeItem("messages");
        },
    },
});
