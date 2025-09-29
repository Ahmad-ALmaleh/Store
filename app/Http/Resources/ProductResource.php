<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'price'         => $this->price, // السعر النهائي (من accessor)
            'original_price'=> $this->getOriginal('price'),
            'description'   => $this->description,
            'exp_date'    => $this->exp_date ? $this->exp_date->toDateString() : null,
            'quantity'      => $this->quantity,
            'img_url'       => $this->img_url,

            'category'      => $this->whenLoaded('category', function () {
                return [
                    'id'   => $this->category->id,
                    'name' => $this->category->name,
                ];
            }),

            'user' => $this->whenLoaded('user', function () {
                return [
                    'id'   => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),

            'likes_count'   => $this->when(isset($this->likes_count), $this->likes_count),
            'comments_count'=> $this->when(isset($this->comments_count), $this->comments_count),

            // عرض الخصومات إن تم تحميلها
            'discounts' => DiscountResource::collection($this->whenLoaded('discounts')),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
