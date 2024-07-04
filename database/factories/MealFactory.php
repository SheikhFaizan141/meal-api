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
            'name' => fake()->text(20),
            'slug' => fake()->unique()->slug(),
            'title' => fake()->text(255),
            'description' => fake()->paragraph(10),
            'featured_img' => fake()->imageUrl(),
            'is_veg' => fake()->boolean(),
            'price' => fake()->numberBetween(150, 4000),
            'rating' => fake()->randomFloat(2, 0, 5),
        ];
    }
}
