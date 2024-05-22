import { defineStore, StoreDefinition } from "pinia";

import { fetchWrapper } from "@/utils/fetch-wrapper";
import router from "@/router/router";
import { AxiosResponse } from "axios";
import { Media } from "@/types";

type StateType = {
    auth?: JSON | null;
    returnUrl: string | null;
    check: boolean;
};

function expiresIn(timeInSeconds: number): number {
    const currentTime = new Date().getTime();
    return currentTime + timeInSeconds;
}

type User = {
    name: string;
    has_avatar: boolean;
    avatar?: object;
};

type Authenticated = {
    user: User;
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
        getAuth(): Authenticated {
            return JSON.parse(
                localStorage.getItem("auth") ?? "null",
            ) as Authenticated;
        },
        setAuth(auth: Authenticated): void {
            this.auth = auth;
            localStorage.setItem("auth", JSON.stringify(auth));
        },
        setUser(user: User): void {
            const auth = this.getAuth();
            auth.user = user;
            this.setAuth(auth);
        },
        setAvatar(avatar: Media): void {
            const auth = this.getAuth();
            auth.user.avatar = avatar;
            auth.user.has_avatar = true;
            this.setAuth(auth);
        },
        unsetAvatar(): void {
            const auth = JSON.parse(localStorage.getItem("auth") ?? "null");
            delete auth.user.avatar;
            auth.user.has_avatar = false;
            this.auth = auth;
            localStorage.setItem("auth", JSON.stringify(auth));
        },
        setToken(token: number) {
            const auth = this.getAuth();
            auth.access_token = expiresIn(token);
            this.set(auth);
        },
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
