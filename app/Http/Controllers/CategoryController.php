<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class CategoryController extends Controller
{

    use AuthorizesRequests;

    public function __construct()
    {
        // نربط الكونترولر بالـ Policy
        $this->authorizeResource(Category::class, 'category');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // جلب كل التصنيفات
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // إنشاء التصنيف
        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
         // عرض تصنيف واحد
         return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
         // التحقق من صحة البيانات
         $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // تحديث التصنيف
        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
