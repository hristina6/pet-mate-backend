<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function index(Category $category, Request $request): AnonymousResourceCollection
    {
        $posts = Post::query()
            ->whereBelongsTo($category)
            ->when($request->input('title'), fn ($query, $title) => $query->where('title', 'like', "%$title%"))
            ->simplePaginate();

        return JsonResource::collection($posts);
    }

    public function show(Category $category, Post $post): JsonResource
    {
        return JsonResource::make($post);
    }

    public function store(Category $category, PostRequest $request): JsonResource
    {
        $post = new Post($request->validated());
        $post->category()->associate($category);
        $post->save();

        return JsonResource::make($post);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Category $category, Post $post, PostRequest $request): JsonResource
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return JsonResource::make($post);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Category $category, Post $post): JsonResource
    {
        $this->authorize('delete', $post);

        $post->delete();

        return JsonResource::make(['message' => 'Post deleted successfully']);
    }
}
