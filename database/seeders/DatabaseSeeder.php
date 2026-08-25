<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ParfumDemoSeeder::class,
            RecommendationSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
