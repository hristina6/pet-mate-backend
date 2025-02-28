<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $posts = Post::query()
            ->when($request->input('title'), fn ($query, $title) => $query->where('title', 'like', "%$title%"))
            ->when($request->input('category_id'), fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->simplePaginate();

        return JsonResource::collection($posts);
    }

    public function show(Post $post): JsonResource
    {
        return JsonResource::make($post);
    }

    public function store(PostRequest $request): JsonResource
    {
        $post = Post::query()->create($request->validated());

        return JsonResource::make($post);
    }

    public function update(PostRequest $request, Post $post): JsonResource
    {
        $post->update($request->validated());

        return JsonResource::make($post);
    }

    public function destroy(Post $post): JsonResource
    {
        $post->delete();

        return JsonResource::make(['message' => 'Post deleted successfully']);
    }
}
