export type Media = {
    href: string;
    width: string | number;
    height: string | number;
    uuid: string;
    format: string;
    base64_preview: string;
    is_video: string | boolean;
};

export type User = {
    id: number;
    name: string;
    has_avatar: boolean;
};

export type Comment = {
    id: number | string;
    author: User;
    text: string;
    comment_id: number;
    reply_id: number;
    replies?: Comment;
};

export type Post = {
    author: User;
    title: string;
    id: number;
    media: Media;
    comments?: Array<Comment>;
    comments_count?: number;
};
