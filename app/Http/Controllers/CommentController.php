<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of comments for a specific product.
     */
    public function index(Product $product)
    {
        $perPage = 5;

        // جلب التعليقات مع المستخدم المرتبط، مختصرة، مع Pagination
        $comments = $product->comments()
                            ->with(['user:id,name,profile_img_url'])
                            ->orderBy('created_at', 'desc')
                            ->paginate($perPage);

        // استجابة JSON
        return response()->json($comments, 200);
    }

    /**
     * Store a newly created comment for a product.
     */
    public function store(CommentStoreRequest $request, Product $product)
{
    /** @var \App\Models\User $user */
    $user = $request->user();

    $comment = $product->comments()->create([
        'content' => $request->validated()['content'],
        'user_id' => $user->id,
    ]);

    return response()->json([
        'message' => 'Comment added successfully',
        'data'    => $comment
    ], 201);
}


    /**
     * Update a specific comment.
     */
    public function update(Request $request, Product $product, Comment $comment)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // التحقق من ملكية التعليق
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => $comment
        ], 200);
    }

    /**
     * Remove a specific comment.
     */
    public function destroy(Request $request, Product $product, Comment $comment)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // التحقق من ملكية التعليق
        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
    }
}
