<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        $students = Student::all();

        foreach ($classes as $i => $class) {
            $subject = $subjects->get($i % $subjects->count());

            $monthly = Exam::create([
                'class_id'   => $class->id,
                'subject_id' => $subject->id,
                'teacher_id' => $class->teacher_id,
                'exam_type'  => 'monthly',
                'title'      => "Monthly {$subject->name} Exam - {$class->name}",
                'exam_date'  => now()->addDays(7)->toDateString(),
                'max_score'  => 100,
            ]);

            $semester = Exam::create([
                'class_id'   => $class->id,
                'subject_id' => $subject->id,
                'teacher_id' => $class->teacher_id,
                'exam_type'  => 'semester',
                'title'      => "Semester {$subject->name} Exam - {$class->name}",
                'exam_date'  => now()->addMonths(2)->toDateString(),
                'max_score'  => 100,
            ]);

            foreach ([$monthly, $semester] as $exam) {
                foreach ($students as $student) {
                    ExamResult::firstOrCreate(
                        ['exam_id' => $exam->id, 'student_id' => $student->id],
                        ['score' => rand(50, 100)]
                    );
                }
            }
        }
    }
}
