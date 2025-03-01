<?php

namespace App\Actions;

use App\Enums\BreedingRequestStatus;
use App\Models\BreedingRequest;

class RejectBreedingRequestAction
{
    public function execute(BreedingRequest $breedingRequest): void
    {
        $breedingRequest->update(['status' => BreedingRequestStatus::REJECTED->value]);
    }
}
