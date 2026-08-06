<?php

namespace Database\Factories;

use App\Enums\PerformanceLevel;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Perfume;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Perfume> */
class PerfumeFactory extends Factory
{
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(2, true));

        return [
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'editorial_story' => fake()->paragraphs(3, true),
            'longevity_level' => fake()->randomElement(PerformanceLevel::cases()),
            'projection_level' => fake()->randomElement(PerformanceLevel::cases()),
            'intensity_level' => fake()->randomElement(PerformanceLevel::cases()),
            'is_featured' => false,
            'is_best_seller' => false,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
