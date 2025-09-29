<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'content'    => $this->content,
            'created_at' => $this->created_at->toIso8601String(),

            'user'       => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'profile_img_url' => $this->user->profile_img_url,
            ],
        ];
    }
}
