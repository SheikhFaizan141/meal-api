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
            'title' => fake()->text(),
            'url' => fake()->imageUrl(),
            'description' => fake()->paragraph(10),
            'is_veg' => fake()->boolean(),
            'price' => fake()->numberBetween(150, 4000),
            'rating' => fake()->randomFloat(2, 0, 5),
        ];
    }
}
