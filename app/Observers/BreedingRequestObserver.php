<?php

namespace App\Observers;

use App\Enums\BreedingRequestStatus;
use App\Models\BreedingRequest;

class BreedingRequestObserver
{
    public function creating(BreedingRequest $breedingRequest): void
    {
        // Status is already set in controller, but ensure it's PENDING
        if (!$breedingRequest->status) {
            $breedingRequest->status = BreedingRequestStatus::PENDING;
        }
    }

    /**
     * Handle the BreedingRequest "created" event.
     */
    public function created(BreedingRequest $breedingRequest): void
    {
        //
    }

    /**
     * Handle the BreedingRequest "updated" event.
     */
    public function updated(BreedingRequest $breedingRequest): void
    {
        //
    }

    /**
     * Handle the BreedingRequest "deleted" event.
     */
    public function deleted(BreedingRequest $breedingRequest): void
    {
        //
    }

    /**
     * Handle the BreedingRequest "restored" event.
     */
    public function restored(BreedingRequest $breedingRequest): void
    {
        //
    }

    /**
     * Handle the BreedingRequest "force deleted" event.
     */
    public function forceDeleted(BreedingRequest $breedingRequest): void
    {
        //
    }
}
