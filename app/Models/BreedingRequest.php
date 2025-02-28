<?php

namespace App\Models;

use App\Enums\BreedingRequestStatus;
use App\Observers\BreedingRequestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(BreedingRequestObserver::class)]
class BreedingRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => BreedingRequestStatus::class,
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
