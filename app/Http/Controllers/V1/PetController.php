<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Models\Pet;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PetController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $pets = Pet::query()
            ->with('user')
            ->when($request->input('type'), fn ($query, $type) => $query->where('type', $type))
            ->when($request->input('user_id'), fn ($query, $userId) => $query->where('user_id', $userId))
            ->simplePaginate();

        return JsonResource::collection($pets);
    }

    public function show(Pet $pet): JsonResource
    {
        $pet->load('user');
        return JsonResource::make($pet);
    }

    public function store(PetRequest $request): JsonResource
    {
        $petData['user_id'] = $request->input('user_id');
        $pet = Pet::query()
            ->create($request->validated());

        $pet->load('user');
        return JsonResource::make($pet);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(PetRequest $request, Pet $pet): JsonResource
    {
        $this->authorize('update', $pet);
        $pet->update($request->validated());

        $pet->load('user');
        return JsonResource::make($pet);
    }
}
