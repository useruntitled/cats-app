import { AxiosResponse } from "axios";
import { fetchWrapper } from "@/utils/fetch-wrapper.ts";

export const mediaApi = {
    upload: (file: File): Promise<AxiosResponse> => {
        const formData = new FormData();
        formData.append("file", file);
        return fetchWrapper.post("/api/media", formData, true);
    },
};
