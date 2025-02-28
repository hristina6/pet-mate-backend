<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    public function index(Request $request, $postId): AnonymousResourceCollection
    {
        $comments = Comment::query()
            ->where('post_id', $postId)
            ->get();

        return JsonResource::collection($comments);
    }

    public function show(Comment $comment): JsonResource
    {
        return JsonResource::make($comment);
    }

    public function store(CommentRequest $request): JsonResource
    {
        $comment = Comment::query()->create($request->validated());

        return JsonResource::make($comment);
    }

    public function update(CommentRequest $request, Comment $comment): JsonResource
    {
        $comment->update($request->validated());

        return JsonResource::make($comment);
    }

    public function destroy(Comment $comment): JsonResource
    {
        $comment->delete();

        return JsonResource::make(['message' => 'Comment deleted successfully']);
    }
}
