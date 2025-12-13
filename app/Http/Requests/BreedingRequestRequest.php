<?php

namespace App\Http\Requests;

use App\Enums\BreedingRequestStatus;
use Illuminate\Foundation\Http\FormRequest;

class BreedingRequestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:'.implode(',', array_map(fn ($status) => $status->value, BreedingRequestStatus::cases())),
            'note' => 'nullable|string|max:500',
            'pet_id' => 'required|exists:pets,id',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
