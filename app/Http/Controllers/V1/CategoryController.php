<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->when($request->input('name'), fn ($query, $name) => $query->where('name', 'like', "%$name%"))
            ->simplePaginate();

        return JsonResource::collection($categories);
    }

    public function show(Category $category): JsonResource
    {
        return JsonResource::make($category);
    }

    public function store(CategoryRequest $request): JsonResource
    {
        $category = Category::query()
            ->create($request->validated());

        return JsonResource::make($category);
    }
}
