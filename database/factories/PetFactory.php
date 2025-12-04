<?php

namespace Database\Factories;

use App\Enums\PetGender;
use App\Enums\PetType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'breed' => $this->faker->word,
            'age' => $this->faker->numberBetween(1, 20),
            'has_pedigree' => $this->faker->boolean,
            'gender' => $this->faker->randomElement([PetGender::MALE->value, PetGender::FEMALE->value]),
            'type' => $this->faker->randomElement([PetType::ADVERTISEMENT->value, PetType::BREEDING->value]),
            'image' => $this->faker->imageUrl(),
            'user_id' => User::factory(),
            'location' => $this->faker->city(),
        ];
    }
}
