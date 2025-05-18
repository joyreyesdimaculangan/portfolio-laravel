<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Create admin user
       User::create([
        'name' => 'Joy Dimaculangan',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now()
    ]);
    }
}
