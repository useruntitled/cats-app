import {
    createRouter,
    createWebHistory,
    NavigationGuardNext,
    RouteLocationNormalized,
    RouteParams,
    RouteParamsRaw,
    RouteRecordRaw,
} from "vue-router";

import {
    AppRouteRecord,
    ModalRecord,
    modals,
    routes,
    TRoutesNames,
} from "./routes";
import { useAuthStore } from "@/stores/auth.store";

const router = createRouter({
    routes: routes as unknown as RouteRecordRaw[],
    history: createWebHistory("/"),
});

router.beforeEach(
    async (
        to: RouteLocationNormalized,
        from: RouteLocationNormalized,
        next: NavigationGuardNext,
    ): Promise<void> => {
        const privatePages: string[] = [""];
        const onlyGuestsPages: string[] = ["/login", "/register"];
        const authRequired: boolean = privatePages.includes(to.path as string);
        const guestRequired: boolean = onlyGuestsPages.includes(
            to.path as string,
        );
        const auth = useAuthStore();

        const hasModal = to.query?.modal != null;

        if (hasModal) {
            console.log(modals);
            modals.forEach((modal: ModalRecord) => {
                if (to.query.modal == modal.name && modal?.middleware) {
                    if (auth.check && modal.middleware == "guest") {
                        next(to.path);
                    }
                    if (!auth.check && modal.middleware == "auth") {
                        next(to.path);
                    }
                }
            });
            if (to.query.modal == "auth" && auth.check) {
                next(to.path);
            }
        }

        if (authRequired && !auth.check) {
            auth.returnUrl = to.path;
            next();
            next({ path: "/login" });
        }

        if (guestRequired && auth.check) {
            auth.returnUrl = to.path;
            next({ path: "/" });
        }

        next();
    },
);

export default router;

export type TRouteTo = {
    name: TRoutesNames;
    params?: RouteParamsRaw;
};

export function route(to: TRouteTo) {
    return to;
}
