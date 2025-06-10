<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->nik(),
            'name' => $this->faker->firstName('male') . ' ' . $this->faker->lastName('male'),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'active' => $this->faker->boolean(90)
        ];
    }
}
