import { AxiosResponse } from "axios";
import { fetchWrapper } from "@/utils/fetch-wrapper.ts";
import { Media } from "@/types";

export const postApi = {
    store: (data: object): Promise<AxiosResponse> => {
        return fetchWrapper.post("/api/posts", data);
    },
    publish: (data: {
        id: number;
        title: string;
        media: Media;
    }): Promise<AxiosResponse> => {
        return fetchWrapper.put("/api/posts/publish", data);
    },
    get: (id: number): Promise<AxiosResponse> => {
        return fetchWrapper.get(`/api/posts/${id}?sorting=new`, {});
    },
    getByProfileId: (
        id: number,
        page: number | string = 1,
    ): Promise<AxiosResponse> => {
        return fetchWrapper.get(
            `/api/posts?user_id=${id}&sorting=new&page=${page}`,
            {},
        );
    },
};
