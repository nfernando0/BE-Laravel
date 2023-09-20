<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
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
            'comments' => $this->comments,
            'news_id' => $this->news_id,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username
            ],
        ];
    }
}
