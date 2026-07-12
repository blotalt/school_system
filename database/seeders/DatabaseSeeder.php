<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@school.test'],
            ['name' => 'Test Admin', 'password' => 'password', 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'teacher@school.test'],
            ['name' => 'Test Teacher', 'password' => 'password', 'role' => 'teacher']
        );

        User::updateOrCreate(
            ['email' => 'student@school.test'],
            ['name' => 'Test Student', 'password' => 'password', 'role' => 'student']
        );
    }
}