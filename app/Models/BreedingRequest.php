<?php

namespace App\Models;

use App\Enums\BreedingRequestStatus;
use App\Observers\BreedingRequestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeMine(Builder $query): Builder
    {
        return $query->where('user_id', auth()->id())
            ->orWhereHas('pet', function (Builder $builder) {
                return $builder->where('user_id', auth()->id());
            });
    }
}
