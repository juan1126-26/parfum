<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('parfum.admin.email')],
            [
                'name' => config('parfum.admin.name'),
                'password' => Hash::make(config('parfum.admin.password')),
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ],
        );
    }
}
