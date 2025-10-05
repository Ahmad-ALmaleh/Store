<?php

namespace App\DTOs\Product;

class StoreProductDTO
{
    public string $name;
    public float $price;
    public ?string $description;
    public ?string $exp_date;
    public ?string $img_url;
    public ?int $quantity;
    public int $category_id;
    public int $user_id;
    public array $discounts;
    public function __construct(
        string $name,
        float $price,
        ?string $description = null,
        ?string $exp_date = null,
        ?string $img_url = null,
        ?int $quantity = null,
        int $category_id,
        int $user_id,
        array $discounts = []
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->exp_date = $exp_date;
        $this->img_url = $img_url;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->user_id = $user_id;
        $this->discounts = $discounts;
    }

    // لتحويل الكائن إلى مصفوفة قبل التخزين
    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'price'       => $this->price,
            'description' => $this->description,
            'exp_date'    => $this->exp_date,
            'img_url'     => $this->img_url,
            'quantity'    => $this->quantity,
            'category_id' => $this->category_id,
            'user_id'     => $this->user_id,
            'discounts'   => $this->discounts,
        ];
    }
}
