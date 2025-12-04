<?php

namespace App\Models;

use App\Enums\PetGender;
use App\Enums\PetType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'location'
    ];

    protected $casts = [
        'gender' => PetGender::class,
        'type' => PetType::class,
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
