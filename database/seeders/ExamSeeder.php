<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Runs AFTER subjects, classes, teachers, students (B2's seeders).
     * Creates one monthly + one semester exam per class, with a result
     * for every student in that class, so the gradebook and student
     * grade views aren't empty on demo day.
     */
    public function run(): void
    {
        $subjects = Subject::all();

        if ($subjects->isEmpty()) {
            return;
        }

        SchoolClass::with('students')->get()->each(function (SchoolClass $class) use ($subjects) {
            if (! $class->teacher_id || $class->students->isEmpty()) {
                return;
            }

            foreach (['monthly', 'semester'] as $type) {
                $exam = Exam::create([
                    'class_id' => $class->id,
                    'subject_id' => $subjects->random()->id,
                    'teacher_id' => $class->teacher_id,
                    'exam_type' => $type,
                    'title' => ucfirst($type) . ' Exam - ' . $class->name,
                    'exam_date' => now()->subDays(random_int(5, 30)),
                    'max_score' => 100,
                ]);

                foreach ($class->students as $student) {
                    ExamResult::create([
                        'exam_id' => $exam->id,
                        'student_id' => $student->id,
                        'score' => random_int(50, 100),
                    ]);
                }
            }
        });
    }
}
