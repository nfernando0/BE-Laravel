<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'comments' => $this->whenLoaded('comments', function () {
                return collect($this->comments)->map(function ($comment) {
                    return new CommentsResource($comment);
                });
            }),
            'image' => $this->image,
            'comments_count' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            })
        ];
    }
}
