<?php

namespace App\Actions;

use App\Enums\BreedingRequestStatus;
use App\Models\BreedingRequest;

class ApproveBreedingRequestAction
{
    public function execute(BreedingRequest $breedingRequest): void
    {
        $breedingRequest->update(['status' => BreedingRequestStatus::APPROVED->value]);
    }
}
