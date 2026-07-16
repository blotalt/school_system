<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        Exam::create([
            'class_id'   => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'exam_type'  => 'monthly',
            'title'      => 'Monthly Math Exam',
            'exam_date'  => now()->addDays(7)->toDateString(),
            'max_score'  => 100,
        ]);

        Exam::create([
            'class_id'   => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'exam_type'  => 'semester',
            'title'      => 'Semester Math Exam',
            'exam_date'  => now()->addMonths(2)->toDateString(),
            'max_score'  => 100,
        ]);
    }
}