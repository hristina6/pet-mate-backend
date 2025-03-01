<?php

namespace App\Observers;

use App\Models\Pet;

class PetObserver
{
    public function creating(Pet $pet): void
    {
        $pet->user()->associate(auth()->user());
    }

    /**
     * Handle the Pet "created" event.
     */
    public function created(Pet $pet): void
    {
        //
    }

    /**
     * Handle the Pet "updated" event.
     */
    public function updated(Pet $pet): void
    {
        //
    }

    /**
     * Handle the Pet "deleted" event.
     */
    public function deleted(Pet $pet): void
    {
        //
    }

    /**
     * Handle the Pet "restored" event.
     */
    public function restored(Pet $pet): void
    {
        //
    }

    /**
     * Handle the Pet "force deleted" event.
     */
    public function forceDeleted(Pet $pet): void
    {
        //
    }
}
