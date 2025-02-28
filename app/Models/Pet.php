<?php

namespace App\Models;

use App\Enums\PetGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    protected $casts = [
        'gender' => PetGender::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function breedingRequests(): HasMany
    {
        return $this->hasMany(BreedingRequest::class);
    }
}
