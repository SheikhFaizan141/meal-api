<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(25),
            'title' => fake()->title(),
            'url' => fake()->imageUrl(),
            'description' => fake()->paragraph(10),
            'price' => fake()->randomFloat(2, 0, 10000),
            'rating' => fake()->randomFloat(2, 0, 5),
        ];
    }
}
