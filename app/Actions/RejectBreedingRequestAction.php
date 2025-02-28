<?php
namespace App\Actions;

use App\Models\BreedingRequest;
use App\Enums\BreedingRequestStatus;

class RejectBreedingRequestAction
{
    public function execute(BreedingRequest $breedingRequest): void
    {
        $breedingRequest->update(['status' => BreedingRequestStatus::REJECTED->value]);
    }
}
