<?php

namespace App\Repositories;

use App\Models\Product;
use App\DTOs\Product\StoreProductDTO;
use App\DTOs\Product\UpdateProductDTO;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Product::query()->with(['user', 'category', 'discounts']);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['price_from'])) {
            $query->where('price', '>=', $filters['price_from']);
        }

        if (!empty($filters['price_to'])) {
            $query->where('price', '<=', $filters['price_to']);
        }

        if (!empty($filters['is_available'])) {
            $query->where('quantity', '>', 0);
        }

        if (!empty($filters['not_expired'])) {
            $query->where('exp_date', '>', now());
        }

        return $query->get();
    }

    public function findById($id)
    {
        return Product::with(['user', 'category', 'discounts'])->find($id);
    }

    public function create(array $data)
    {
        $product = Product::create($data);

        if (!empty($data['discounts'])) {
            foreach ($data['discounts'] as $discountData) {
                $product->discounts()->create($discountData);
            }
        }

        return $product->load('discounts');
    }

    public function update($id, $data)
    {
        $product = Product::findOrFail($id);

        if ($data instanceof UpdateProductDTO) {
            $updateData = array_filter([
                'name'        => $data->name,
                'price'       => $data->price,
                'description' => $data->description,
                'exp_date'    => $data->exp_date,
                'img_url'     => $data->img_url,
                'quantity'    => $data->quantity,
                'category_id' => $data->category_id,
            ]);

            $product->update($updateData);

            if (!empty($data->discounts)) {
                foreach ($data->discounts as $discountData) {
                    $product->discounts()->create($discountData);
                }
            }
        } else {
            $product->update($data); // fallback if $data is array
        }

        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return true;
    }
}
