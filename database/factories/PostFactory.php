<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
        ];
    }
}