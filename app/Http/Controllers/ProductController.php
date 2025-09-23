<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category_id = $request->query('category_id');
        $price_from  = $request->query('price_from');
        $price_to    = $request->query('price_to');
        $is_available = $request->query('is_available');
        $not_expired  = $request->query('not_expired'); // لو بدنا نتحقق من انتهاء الصلاحية

        $productQuery = Product::query();

        // فلترة حسب التصنيف
        if ($category_id) {
            $productQuery->where('category_id', $category_id);
        }

        // فلترة حسب السعر الأدنى
        if ($price_from) {
            $productQuery->where('price', '>=', $price_from);
        }

        // فلترة حسب السعر الأعلى
        if ($price_to) {
            $productQuery->where('price', '<=', $price_to);
        }

        // فلترة حسب توفر المنتج (quantity > 0)
        if ($is_available) {
            $productQuery->where('quantity', '>', 0);
        }

        // فلترة حسب تاريخ الانتهاء (المنتجات غير المنتهية فقط)
        if ($not_expired) {
            $productQuery->where('exp_date', '>', now());
        }

        $products = $productQuery->get();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /** @var \App\Models\User $user */
        $user = $request->user();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'exp_date'    => 'nullable|date',
            'img_url'     => 'nullable|string',
            'quantity'    => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // نخزن user_id للمستخدم الحالي (اللي عامل login)
        $validated['user_id'] = $user->id;

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['user', 'category'])->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    $validated = $request->validate([
        'name'        => 'sometimes|string|max:255',
        'price'       => 'sometimes|numeric|min:0',
        'description' => 'nullable|string',
        'exp_date'    => 'nullable|date',
        'img_url'     => 'nullable|string',
        'quantity'    => 'sometimes|integer|min:0',
        'category_id' => 'sometimes|exists:categories,id',
    ]);

    $product->update($validated);

    return response()->json([
        'message' => 'Product updated successfully',
        'data'    => $product
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
