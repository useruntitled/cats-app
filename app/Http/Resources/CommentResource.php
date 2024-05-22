<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => $this->user,
            'post_id' => $this->post_id,
            'comment_id' => $this->comment_id,
            'reply_id' => $this->reply_id,
            'text' => $this->text,
            'replies' => CommentResource::collection($this->replies),
        ];
    }
}
