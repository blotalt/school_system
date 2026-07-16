<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SchoolClass::all();
        $firstClass = $classes->first();

        // Link B1's existing test student to a student profile
        $testStudent = User::where('email', 'student@school.test')->first();
        if ($testStudent && ! $testStudent->student) {
            Student::create([
                'user_id'  => $testStudent->id,
                'class_id' => $firstClass->id,
                'roll_no'  => 'STU-001',
            ]);
        }

        // Additional seeded students
        $studentData = [
            ['name' => 'John Doe',     'email' => 'john@school.test',   'roll' => 'STU-002'],
            ['name' => 'Jane Smith',   'email' => 'jane@school.test',   'roll' => 'STU-003'],
            ['name' => 'Carlos Reyes', 'email' => 'carlos@school.test', 'roll' => 'STU-004'],
            ['name' => 'Mia Pham',     'email' => 'mia@school.test',    'roll' => 'STU-005'],
        ];

        foreach ($studentData as $i => $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => 'password', 'role' => 'student']
            );

            if (! $user->student) {
                Student::create([
                    'user_id'  => $user->id,
                    'class_id' => $classes->get($i % $classes->count())->id,
                    'roll_no'  => $data['roll'],
                ]);
            }
        }
    }
}
