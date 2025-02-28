<?php

namespace App\Http\Controllers\V1;

use App\Actions\ApproveBreedingRequestAction;
use App\Actions\RejectBreedingRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreedingRequestRequest;
use App\Models\BreedingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BreedingRequestController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $breedingRequests = BreedingRequest::query()
            ->simplePaginate();
        return JsonResource::collection($breedingRequests);
    }


    public function store(BreedingRequestRequest $request): JsonResource
    {
        $breedingRequest = BreedingRequest::query()->create($request->validated());
        return JsonResource::make($breedingRequest);
    }

    public function show(BreedingRequest $breedingRequest): JsonResource
    {
        return JsonResource::make($breedingRequest);
    }

    public function update(BreedingRequestRequest $request, BreedingRequest $breedingRequest): JsonResource
    {
        $breedingRequest->update($request->validated());
        return JsonResource::make($breedingRequest);
    }


    public function destroy(BreedingRequest $breedingRequest): JsonResource
    {
        $breedingRequest->delete();
        return JsonResource::make(['message' => 'Post deleted successfully']);
    }

    public function approve(BreedingRequest $breedingRequest): JsonResource
    {
        (new ApproveBreedingRequestAction())->execute($breedingRequest);

        return JsonResource::make([
            'message' => __('The breeding request has been approved successfully!')
        ]);
    }

    public function reject(BreedingRequest $breedingRequest): JsonResource
    {
        (new RejectBreedingRequestAction())->execute($breedingRequest);

        return JsonResource::make([
            'message' => __('The breeding request has been rejected successfully!')
        ]);
    }
}
