<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerData>
 */
class CustomerDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'house_number' => fake()->buildingNumber(),
            'address_1' => fake()->streetName(),
            'address_2' => fake()->optional()->secondaryAddress(),
            'postcode' => fake()->postcode(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'rating' => fake()->randomElement(['Bronze', 'Silver', 'Gold', 'Platinum']),
            'rating_manual' => false,
        ];
    }
}
