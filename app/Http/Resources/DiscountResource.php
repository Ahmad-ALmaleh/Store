<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                  => $this->id,
            'discount_date'      => $this->discount_date ? $this->discount_date->toDateString() : null, // 🟢 Carbon safe
            'discount_percentage' => $this->discount_percentage,
        ];
    }
}
