<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);

        User::factory()->create([
            'name' => 'Staff User',
            'username' => 'staff',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
            'role' => 'STAFF',
        ]);
    }
}
