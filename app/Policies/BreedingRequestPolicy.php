<?php

namespace App\Policies;

use App\Models\BreedingRequest;
use App\Models\User;

class BreedingRequestPolicy
{
    public function view(User $user, BreedingRequest $breedingRequest): bool
    {
        return $user->id === $breedingRequest->user_id || $user->id === $breedingRequest->pet->user_id;
    }

    public function approveOrReject(User $user, BreedingRequest $breedingRequest): bool
    {
        return $user->id === $breedingRequest->pet->user_id;
    }
}
