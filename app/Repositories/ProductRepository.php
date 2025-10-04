<?php

namespace App\Repositories;

use App\Models\Product;

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

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return true;
    }
}
