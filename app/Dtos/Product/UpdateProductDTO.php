<?php

namespace App\DTOs\Product;

class UpdateProductDTO
{
    public ?string $name = null;
    public ?float $price = null;
    public ?string $description = null;
    public ?string $exp_date = null;
    public ?string $img_url = null;
    public ?int $quantity = null;
    public ?int $category_id = null;
    public array $discounts = [];

    public function __construct(array $data)
    {
        $this->name        = $data['name'] ?? null;
        $this->price       = $data['price'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->exp_date    = $data['exp_date'] ?? null;
        $this->img_url     = $data['img_url'] ?? null;
        $this->quantity    = $data['quantity'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->discounts   = $data['discounts'] ?? [];
    }
}
