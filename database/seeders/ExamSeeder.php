<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;

/**
 * For each class, creates a monthly + semester exam for that class's 4
 * most-frequently-taught subjects (its real timetable, not an arbitrary
 * pick), with the correct teacher for that class/subject. Exam results are
 * scoped to students actually enrolled in that exam's class (the old
 * seeder attached every student in the DB to every exam — fixed here).
 */
class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SchoolClass::with('schedules.subject')->get();

        foreach ($classes as $class) {
            $students = Student::where('class_id', $class->id)->get();
            if ($students->isEmpty()) {
                continue;
            }

            // The 4 subjects this class is taught most often, each with the
            // teacher who actually teaches it to this class.
            $bySubject = $class->schedules->groupBy('subject_id');
            $topSubjects = $bySubject->sortByDesc(fn ($rows) => $rows->count())->take(4);

            foreach ($topSubjects as $subjectId => $rows) {
                $subject = $rows->first()->subject;
                $teacherId = $rows->first()->teacher_id;

                $monthly = Exam::create([
                    'class_id'   => $class->id,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'exam_type'  => 'monthly',
                    'title'      => "Monthly {$subject->name} Exam - {$class->name}",
                    'exam_date'  => now()->subDays(random_int(3, 20))->toDateString(),
                    'max_score'  => 100,
                ]);

                $semester = Exam::create([
                    'class_id'   => $class->id,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'exam_type'  => 'semester',
                    'title'      => "Semester {$subject->name} Exam - {$class->name}",
                    'exam_date'  => now()->addDays(random_int(14, 60))->toDateString(),
                    'max_score'  => 100,
                ]);

                foreach ([$monthly, $semester] as $exam) {
                    foreach ($students as $student) {
                        // Average of 3 rolls for a believable bell-ish spread instead of flat rand(50,100).
                        $score = (int) round((random_int(35, 100) + random_int(35, 100) + random_int(35, 100)) / 3);

                        ExamResult::firstOrCreate(
                            ['exam_id' => $exam->id, 'student_id' => $student->id],
                            ['score' => min(100, max(0, $score))]
                        );
                    }
                }
            }
        }
    }
}
