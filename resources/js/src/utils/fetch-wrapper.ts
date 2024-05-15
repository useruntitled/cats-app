import { useAuthStore } from "@/stores/auth.store.js";
import axios, {
    AxiosError,
    AxiosInstance,
    AxiosRequestConfig,
    AxiosResponse,
} from "axios";
import { isPast, parseISO } from "date-fns";

const axiosJwtApi = axios.create();

export type AxiosErrorResponse = {
    response: AxiosResponse;
} & AxiosError;

export const fetchWrapper = {
    get: request("GET"),
    post: request("POST"),
    put: request("PUT"),
    delete: request("DELETE"),
};

function request(method: string) {
    return (url: string, body: object | FormData): Promise<AxiosResponse> => {
        setAuthHeader(url);
        refreshTokenIfNeeded();

        axiosJwtApi.interceptors.response.use(
            (response: AxiosResponse) => response,
            (error: AxiosErrorResponse) => {
                if (
                    error.response?.status === 401 ||
                    error.response?.status === 403
                ) {
                    const { logout } = useAuthStore();
                    logout();
                }
                return Promise.reject(error);
            },
        );
        if (method != "GET") {
            return axiosJwtApi.post(url, {
                _method: method,
                ...body,
            });
        }
        return axiosJwtApi.get(url);
    };
}

function setAuthHeader(url: string = "", force: boolean = false): void {
    const { auth } = useAuthStore();
    const isLoggedIn = !!auth?.access_token;
    const isApiUrl = url.startsWith("/api");
    if ((isLoggedIn && isApiUrl) || force) {
        axiosJwtApi.interceptors.request.use((config: AxiosRequestConfig) => {
            config.headers.Authorization = `Bearer ${auth.access_token}`;
            return config;
        });
    }
}

function refreshTokenIfNeeded(): void {
    const auth = useAuthStore();
    if (auth.check && isPast(new Date(auth.auth.expires_in))) {
        console.log(
            "expires",
            isPast(new Date(auth.auth.expires_in)),
            auth.auth.expires_in,
        );
        setAuthHeader("", true);
        axiosJwtApi.post("/api/refresh").then((res: AxiosResponse) => {
            console.log(res);
            if (res.status === 200) {
                auth.set(res.data);
            }
        });
    }
}
