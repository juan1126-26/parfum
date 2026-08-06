<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Note> */
class NoteFactory extends Factory
{
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->word());

        return ['name' => $name, 'slug' => Str::slug($name), 'description' => fake()->sentence(), 'is_active' => true, 'sort_order' => fake()->numberBetween(1, 20)];
    }
}
