<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepositoryInterface;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use App\DTOs\Product\StoreProductDTO;

use App\DTOs\Product\UpdateProductDTO;


class ProductController extends Controller
{
    use AuthorizesRequests;

    private $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->middleware('auth');
        $this->authorizeResource(\App\Models\Product::class, 'product', ['except' => ['show']]);
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'price_from', 'price_to', 'is_available', 'not_expired']);
        $products = $this->productRepo->getAll($filters);
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = $this->productRepo->findById($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return new ProductResource($product);
    }

    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();

        $dto = new StoreProductDTO(
            name: $validated['name'],
            price: $validated['price'],
            description: $validated['description'] ?? null,
            exp_date: $validated['exp_date'] ?? null,
            img_url: $validated['img_url'] ?? null,
            quantity: $validated['quantity'] ?? null,
            category_id: $validated['category_id'],
            user_id: $request->user()->id, // 🔥 إضافة user_id من المستخدم المسجل
            discounts: $validated['discounts'] ?? []
        );

        $product = $this->productRepo->create($dto->toArray());

        return response()->json([
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $dto = new UpdateProductDTO($request->validated());
        $product = $this->productRepo->update($id, $dto);

        return response()->json([
            'message' => 'Product updated successfully',
            'data'    => $product
        ], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->productRepo->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
