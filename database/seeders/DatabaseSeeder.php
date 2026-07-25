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
            [
                'name'       => 'Test Admin',
                'khmer_name' => 'គ្រប់គ្រង​ ធ្វើ​តេស្ត',
                'password'   => '123123123',
                'role'       => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'teacher@school.test'],
            [
                'name'       => 'Test Teacher',
                'khmer_name' => 'គ្រូ​ ធ្វើ​តេស្ត',
                'password'   => '123123123',
                'role'       => 'teacher',
            ]
        );

        User::updateOrCreate(
            ['email' => 'student@school.test'],
            [
                'name'       => 'Test Student',
                'khmer_name' => 'សិស្ស​ ធ្វើ​តេស្ត',
                'password'   => '123123123',
                'role'       => 'student',
            ]
        );

        $this->call([
            SubjectSeeder::class,
            TeacherSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            ClassScheduleSeeder::class,
            TeacherAvailabilitySeeder::class,
            ScheduleRequestSeeder::class,
            ExamSeeder::class,
            AttendanceSeeder::class,
            HomeworkSeeder::class,
            HomeworkSubmissionSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
