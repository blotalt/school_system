<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // B1 — seed test accounts (kept exactly as B1 wrote it)
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

        // B2 — order matters: subjects → teachers → classes → students
        $this->call([
            SubjectSeeder::class,
            TeacherSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
        ]);

        // B3
        $this->call([
            ExamSeeder::class,
            AttendanceSeeder::class,
        ]);

        // B4 — announcements (B4 owns this table; runs last, after users exist)
        $this->call([
            AnnouncementSeeder::class,
        ]);
    }
}
