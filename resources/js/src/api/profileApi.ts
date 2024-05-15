import { fetchWrapper } from "@/utils/fetch-wrapper.ts";
import { AxiosResponse } from "axios";

export const profileApi = {
    get: (id: number, callback = (...params: any[]) => {}): any => {
        fetchWrapper.get(`/api/users/${id}`, {}).then((res) => {
            return callback(res);
        });
    },
    uploadAvatar: (id: number, file: File): Promise<AxiosResponse> => {
        const formData = new FormData();
        formData.append("id", id);
        formData.append("file", file);
        return fetchWrapper.post(`/api/users/${id}/avatar`, formData);
    },
};
