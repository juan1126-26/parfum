<?php

namespace Database\Factories;

use App\Models\Perfume;
use App\Models\PerfumeImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PerfumeImage> */
class PerfumeImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'perfume_id' => Perfume::factory(),
            'path' => fake()->unique()->imageUrl(),
            'alt_text' => fake()->sentence(4),
            'is_cover' => false,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
