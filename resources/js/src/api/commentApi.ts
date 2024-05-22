import { AxiosResponse } from "axios";
import { fetchWrapper } from "@/utils/fetch-wrapper.ts";

export const commentApi = {
    getByPostId: (postId: Number | string): Promise<AxiosResponse> => {
        return fetchWrapper.get(
            `/api/comments?post_id=${postId}&sorting=new`,
            {},
        );
    },
    getByUserId: (
        userId: number | string,
        page: number | string = 1,
    ): Promise<AxiosResponse> => {
        return fetchWrapper.get(
            `/api/comments?user_id=${userId}&sorting=new&page=${page}`,
            {},
        );
    },
    store: (
        postId: number | string,
        commentId: number | string | null,
        replyId: number | string | null,
        text: string,
    ): Promise<AxiosResponse> => {
        return fetchWrapper.post("/api/comments", {
            post_id: postId,
            comment_id: commentId,
            reply_id: replyId,
            text: text,
        });
    },
};
