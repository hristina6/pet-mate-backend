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
            ->with(['user'])
            ->whereBelongsTo($post)
            ->get();

        return JsonResource::collection($comments);
    }

    public function store(Category $category, Post $post, CommentRequest $request): JsonResource
    {
        $commentData = $request->validated();

        // Add user_id to the comment data if provided in the request
        if ($request->has('user_id')) {
            $commentData['user_id'] = $request->input('user_id');
        }

        $comment = new Comment($commentData);
        $comment->post()->associate($post);
        $comment->save();

        // Load the user relationship for the response
        $comment->load('user');

        return JsonResource::make($comment);
    }
    public function destroy(Category $category, Post $post, Comment $comment): JsonResource
    {
        $comment->delete();

        return JsonResource::make(['message' => 'Comment deleted successfully']);
    }
}
