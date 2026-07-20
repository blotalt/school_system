<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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

        $this->call([
            SubjectSeeder::class,
            TeacherSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            ExamSeeder::class,
            AttendanceSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
