import { fetchWrapper } from "@/utils/fetch-wrapper.ts";
import { AxiosResponse } from "axios";

export const profileApi = {
    get: (id: number, callback = (...params: any[]) => {}): any => {
        fetchWrapper.get(`/api/users/${id}`, {}).then((res) => {
            return callback(res);
        });
    },
    uploadAvatar: (uuid: string): Promise<AxiosResponse> => {
        return fetchWrapper.post(`/api/me/avatar`, {
            uuid: uuid,
        });
    },
    deleteAvatar: (uuid: string): Promise<AxiosResponse> => {
        return fetchWrapper.delete("/api/me/avatar", {
            uuid: uuid,
        });
    },
};
