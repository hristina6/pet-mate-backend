<?php
namespace App\Actions;

use App\Models\BreedingRequest;
use App\Enums\BreedingRequestStatus;

class ApproveBreedingRequestAction
{
    public function execute(BreedingRequest $breedingRequest): void
    {
        $breedingRequest->update(['status' => BreedingRequestStatus::APPROVED->value]);
    }
}
