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
            'name' => 'Administrator Romansa',
            'email' => 'admin@romansa.com',
            'password' => bcrypt('password'), // Password default: password
        ]);

        User::factory()->create([
            'name' => 'Staff Romansa',
            'email' => 'staff@romansa.com',
            'password' => bcrypt('password'),
        ]);
    }
}
