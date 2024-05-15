import { defineStore, StoreDefinition } from "pinia";

import { fetchWrapper } from "@/utils/fetch-wrapper";
import router from "@/router/router";
import { AxiosResponse } from "axios";

type StateType = {
    auth?: JSON | null;
    returnUrl: string | null;
    check: boolean;
};

function expiresIn(timeInSeconds: number): number {
    const currentTime = new Date().getTime();
    return currentTime + timeInSeconds;
}

type Authenticated = {
    user: object;
    access_token: number;
};

type AuthResponseJson = {
    user: object;
    expires_in: number;
};

export const useAuthStore: StoreDefinition = defineStore({
    id: "auth",
    state: () =>
        ({
            auth: JSON.parse(
                localStorage.getItem("auth") ?? "null",
            ) as Authenticated | null,
            returnUrl: null,
            check: !!localStorage.getItem("auth"),
        }) as StateType,
    actions: {
        set(auth: AuthResponseJson) {
            const data = auth;
            data.expires_in = expiresIn(data.expires_in);
            localStorage.setItem("auth", JSON.stringify(data));
            this.auth = data;
            console.log(data);
        },
        async login(email: string, password: string): Promise<AxiosResponse> {
            const res = await fetchWrapper.post(`/api/login`, {
                email,
                password,
            });

            if (res.status === 200) {
                this.set(res.data);
                this.check = !!res.data.access_token;
                router.push(this.returnUrl || "/");
                return res;
            }

            return Promise.reject(res);
        },
        logout(): void {
            this.auth = null;
            this.check = false;
            this.returnUrl = null;
            localStorage.removeItem("auth");
            // router.push({ name: "login" });
        },
    },
});
