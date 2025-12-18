<?php

namespace App\Http\Controllers\V1;

use App\Actions\ApproveBreedingRequestAction;
use App\Actions\RejectBreedingRequestAction;
use App\Enums\BreedingRequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreedingRequestRequest;
use App\Models\BreedingRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BreedingRequestController extends Controller
{
    public function index(Request $request)
    {
        $breedingRequests = BreedingRequest::with('pet','user')->simplePaginate();

        // Convert to array to ensure relationships are included
        $data = $breedingRequests->toArray();

        return response()->json($data);
    }
    public function store(BreedingRequestRequest $request): JsonResource
    {
        // Create breeding request with validated data including user_id
        $breedingRequest = BreedingRequest::query()->create([
            'status' => BreedingRequestStatus::PENDING, // Always set to PENDING
            'note' => $request->input('note', ''),
            'pet_id' => $request->input('pet_id'),
            'user_id' => $request->input('user_id'), // Use user_id from request
        ]);

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
    public function approve(Request $request, BreedingRequest $breedingRequest): JsonResource
    {
        // Земи го user_id од request body
        $userId = $request->input('user_id');

        // Провери дали овој user е сопственик на миленичето
        if ($userId && $breedingRequest->pet->user_id == $userId) {
            (new ApproveBreedingRequestAction)->execute($breedingRequest);
            return JsonResource::make([
                'message' => __('The breeding request has been approved successfully!'),
            ]);
        }

        throw new AuthorizationException('This action is unauthorized.');
    }
    /**
     * @throws AuthorizationException
     */
    public function reject(Request $request, BreedingRequest $breedingRequest): JsonResource
    {
        // Земи го user_id од request body
        $userId = $request->input('user_id');

        // Провери дали овој user е сопственик на миленичето
        if ($userId && $breedingRequest->pet->user_id == $userId) {
            (new RejectBreedingRequestAction)->execute($breedingRequest);
            return JsonResource::make([
                'message' => __('The breeding request has been rejected successfully!'),
            ]);
        }

        throw new AuthorizationException('This action is unauthorized.');
    }
}
