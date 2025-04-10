<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeaturedItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'subtitle' => fake()->sentence(),
            'imagePath' => 'images/featured/' . fake()->image('public/images/featured', 1920, 1080, null, false),
            'button_text' => fake()->words(2, true),
            'button_link' => fake()->url(),
            'is_active' => true,
            'order' => fake()->numberBetween(1, 10)
        ];
    }
} 