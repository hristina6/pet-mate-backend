<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    public function index(Category $category, Post $post): AnonymousResourceCollection
    {
        $comments = Comment::query()
            ->whereBelongsTo($post)
            ->get();

        return JsonResource::collection($comments);
    }

    public function store(Category $category, Post $post, CommentRequest $request): JsonResource
    {
        $comment = new Comment($request->validated());
        $comment->post()->associate($post);
        $comment->save();

        return JsonResource::make($comment);
    }

    public function destroy(Category $category, Post $post, Comment $comment): JsonResource
    {
        $comment->delete();

        return JsonResource::make(['message' => 'Comment deleted successfully']);
    }
}
