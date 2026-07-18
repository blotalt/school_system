<?php

namespace Database\Seeders;

use App\Models\Subject;
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
            $teacher = Teacher::create([
                'user_id'           => $testTeacher->id,
                'subject_specialty' => 'Mathematics',
            ]);
            $this->attachSubject($teacher, 'Mathematics');
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
                $teacher = Teacher::create([
                    'user_id'           => $user->id,
                    'subject_specialty' => $data['specialty'],
                ]);
                $this->attachSubject($teacher, $data['specialty']);
            }
        }
    }

    private function attachSubject(Teacher $teacher, string $subjectName): void
    {
        $subject = Subject::where('name', $subjectName)->first();

        if ($subject) {
            $teacher->subjects()->syncWithoutDetaching([$subject->id]);
        }
    }
}
