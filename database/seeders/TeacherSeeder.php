<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Link B1's existing test teacher to a teacher profile
        $testTeacher = User::where('email', 'teacher@school.test')->first();
        if ($testTeacher && ! $testTeacher->teacher) {
            Teacher::create([
                'user_id'           => $testTeacher->id,
                'subject_specialty' => 'Mathematics',
            ]);
        }

        // Additional seeded teachers
        $teacherData = [
            ['name' => 'Alice Nguyen', 'email' => 'alice@school.test', 'specialty' => 'Physics'],
            ['name' => 'Clara Tan',    'email' => 'clara@school.test', 'specialty' => 'Biology'],
            ['name' => 'David Lee',    'email' => 'david@school.test', 'specialty' => 'English'],
        ];

        foreach ($teacherData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => 'password', 'role' => 'teacher']
            );

            if (! $user->teacher) {
                Teacher::create([
                    'user_id'           => $user->id,
                    'subject_specialty' => $data['specialty'],
                ]);
            }
        }
    }
}
