<?php

namespace App\Http\Controllers\V1;

use App\Actions\ApproveBreedingRequestAction;
use App\Actions\RejectBreedingRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreedingRequestRequest;
use App\Models\BreedingRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BreedingRequestController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $breedingRequests = BreedingRequest::query()
            ->mine()
            ->simplePaginate();

        return JsonResource::collection($breedingRequests);
    }

    public function store(BreedingRequestRequest $request): JsonResource
    {
        $breedingRequest = BreedingRequest::query()->create($request->validated());

        return JsonResource::make($breedingRequest);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(BreedingRequest $breedingRequest): JsonResource
    {
        $this->authorize('view', $breedingRequest);

        return JsonResource::make($breedingRequest);
    }

    /**
     * @throws AuthorizationException
     */
    public function approve(BreedingRequest $breedingRequest): JsonResource
    {
        $this->authorize('approveOrReject', $breedingRequest);
        (new ApproveBreedingRequestAction)->execute($breedingRequest);

        return JsonResource::make([
            'message' => __('The breeding request has been approved successfully!'),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function reject(BreedingRequest $breedingRequest): JsonResource
    {
        $this->authorize('approveOrReject', $breedingRequest);
        (new RejectBreedingRequestAction)->execute($breedingRequest);

        return JsonResource::make([
            'message' => __('The breeding request has been rejected successfully!'),
        ]);
    }
}
