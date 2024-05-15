import Home from "@/Pages/Home.vue";
import Logout from "@/Pages/Auth/Logout.vue";
import { RouteRecordRaw } from "vue-router";
import Profile from "@/Pages/Profile.vue";

export type AppRouteRecord = Omit<RouteRecordRaw, "name" | "children"> & {
    name: string;
    children?: readonly AppRouteRecord[];
};

export type ModalRecord = {
    name: string;
    middleware?: string;
};

export type GetRouteName<T extends AppRouteRecord> = T extends {
    children: readonly AppRouteRecord[];
}
    ? T["name"] | GetRoutesNames<T["children"]>
    : T["name"];

export type GetRoutesNames<T extends readonly AppRouteRecord[]> = GetRouteName<
    T[number]
>;

export const routes = [
    {
        name: "/",
        path: "/",
        component: Home,
    },
    {
        name: "logout",
        path: "/logout",
        component: Logout,
    },
    {
        name: "me",
        path: "/users",
        component: Profile,
    },
    {
        name: "user",
        path: "/users/:id",
        component: Profile,
    },
] as const satisfies readonly AppRouteRecord[];

export const modals = [
    {
        name: "auth",
        middleware: "guest",
    },
    {
        name: "profile-edit",
        middleware: "auth",
    },
] as const satisfies readonly ModalRecord[];

export type TRoutes = typeof routes;
export type TRoutesNames = GetRoutesNames<TRoutes>;

export default routes;
