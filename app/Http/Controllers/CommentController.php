<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
class CommentController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->middleware('auth');

        // ربط الـ Policy تلقائيًا مع Resource Controller
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * عرض جميع التعليقات لمنتج محدد مع Pagination.
     */
    public function index(Product $product)
    {
        $perPage = 5;

        $comments = $product->comments()
            ->with('user:id,name,profile_img_url')
            ->latest()
            ->paginate($perPage);

        return CommentResource::collection($comments);
    }

    /**
     * إضافة تعليق جديد على المنتج.
     */
    public function store(CommentStoreRequest $request, Product $product)
    {
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
     * تعديل تعليق موجود.
     */
    public function update(UpdateCommentRequest $request, Product $product, Comment $comment)
    {
        $user = $request->user();

        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->update([
            'content' => $request->validated()['content'],
        ]);

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => new CommentResource($comment->load('user'))
        ], 200);
    }

    /**
     * حذف تعليق محدد.
     */
    public function destroy(Request $request, Product $product, Comment $comment)
    {
        $user = $request->user();

        if ($comment->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
    }
}
