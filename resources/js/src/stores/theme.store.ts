import { defineStore, StoreDefinition } from "pinia";

type StateType = {
    theme?: string;
};

export const useThemeStore: StoreDefinition = defineStore({
    id: "theme",
    state: () =>
        ({
            theme: localStorage.getItem("theme"),
        }) as StateType,
    actions: {
        toggle(): void {
            if (this?.theme === "dark") {
                localStorage.setItem("theme", "light");
                this.theme = "light";
            } else {
                localStorage.setItem("theme", "dark");
                this.theme = "dark";
            }
        },
        set(theme: string): void {
            localStorage.setItem("theme", theme);
            this.theme = "dark";
        },
    },
});
