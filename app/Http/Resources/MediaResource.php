<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'width' => $this->width,
            'height' => $this->height,
            'base64_preview' => $this->base64_preview,
            'href' => $this->href,
            'format' => $this->format,
            'is_video' => $this->is_video,
        ];
    }
}
