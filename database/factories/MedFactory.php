<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Med>
 */
class MedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scientific_name' => $this->faker->sentence(),
            'commercial_name' => $this->faker->unique()->sentence(),
            'category' => $this->faker->sentence(),
            'manufacturer_name' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(),
            'expiration_date' => $this->faker->date(),
            'quantity_available' => $this->faker->numberBetween()
        ];
    }
}
