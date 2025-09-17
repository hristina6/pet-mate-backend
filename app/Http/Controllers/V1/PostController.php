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
    public function index(Request $request): AnonymousResourceCollection
    {
        $posts = Post::query()
            ->with(['user', 'category']) // Eager load relationships
            ->when($request->input('user_id'), function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($request->input('category_id'), function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($request->input('title'), function ($query, $title) {
                return $query->where('title', 'like', "%$title%");
            })
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return JsonResource::collection($posts);
    }

    // In your PostController index method

    public function show(Category $category, Post $post): JsonResource
    {
        return JsonResource::make($post);
    }

    public function store(Category $category, PostRequest $request): JsonResource
    {
        $postData = $request->validated();

        // Add user_id to the post data if provided in the request
        if ($request->has('user_id')) {
            $postData['user_id'] = $request->input('user_id');
        }

        $post = new Post($postData);
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
