<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * استعراض اللايكات لمنتج معين
     */
    public function index(Product $product)
    {
        // عدد اللايكات
        $likesCount = $product->likes()->count();

        // يمكنك أيضاً جلب المستخدمين الذين أعطوا لايك
        $users = $product->likes()->with('user:id,name,profile_img_url')->get()->pluck('user');

        return response()->json([
            'product_id' => $product->id,
            'likes_count' => $likesCount,
            'users' => $users
        ], 200);
    }

    /**
     * إضافة لايك
     */
    public function store(Request $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // التحقق إذا كان المستخدم أعطى لايك مسبقاً
        if ($product->likes()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You already liked this product.'
            ], 400);
        }

        $like = Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        return response()->json([
            'message' => 'Product liked successfully.',
            'data' => $like
        ], 201);
    }

    /**
     * إزالة لايك
     */
    public function destroy(Request $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $like = $product->likes()->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json([
                'message' => 'You have not liked this product.'
            ], 404);
        }

        $like->delete();

        return response()->json([
            'message' => 'Like removed successfully.'
        ], 200);
    }
}
