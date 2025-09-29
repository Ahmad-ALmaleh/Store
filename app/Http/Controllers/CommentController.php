<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
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
        return CommentResource::collection(
            $product->comments()
                ->with('user') // جلب بيانات المستخدم
                ->latest()
                ->paginate(5)
        );
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
        'data' => new CommentResource($comment->load('user'))
    ], 201);
}


    /**
     * Update a specific comment.
     */
    public function update(UpdateCommentRequest $request, Product $product, Comment $comment)
{
    /** @var \App\Models\User $user */
    $user = $request->user();

    // التحقق من ملكية التعليق
    if ($comment->user_id !== $user->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $comment->update([
        'content' => $request->validated()['content'],
    ]);

    return response()->json([
        'message' => 'Comment added successfully',
        'data' => new CommentResource($comment->load('user'))
    ], 201);
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
