<?php

namespace App\Http\Requests;

use App\Enums\PetGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'breed' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0', 'max:50'],
            'has_pedigree' => ['required', 'boolean'],
            'gender' => ['required', new Enum(PetGender::class)],
            'image' => ['nullable', 'string', 'url'],
            'user_id' => ['required', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
