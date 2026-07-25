<?php

namespace Database\Seeders;

use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * ~70% of a class's students submit each homework; of those, ~60% are
 * already graded (score/feedback/graded_at set) and the rest are still
 * awaiting grading. Placeholder file_path/file_name — no real uploaded
 * file is generated (same limitation any seeder has for user uploads), so
 * download links on these rows won't resolve to an actual file.
 */
class HomeworkSubmissionSeeder extends Seeder
{
    private const FEEDBACK_SAMPLES = [
        'Great work, well organized and complete.',
        'Good effort — double check question 3 next time.',
        'Solid submission, minor errors in the calculations.',
        'Well done, clear explanations throughout.',
        'Needs more detail in your reasoning, but on the right track.',
    ];

    public function run(): void
    {
        $homeworks = Homework::all();

        foreach ($homeworks as $homework) {
            $students = Student::where('class_id', $homework->class_id)->orderBy('id')->get();
            $dueDate = Carbon::parse($homework->due_date);

            foreach ($students as $i => $student) {
                // ~70% submission rate, deterministic.
                if ($i % 10 >= 7) {
                    continue;
                }

                // Most submit a day or two before the deadline, some late.
                $submittedAt = $dueDate->copy()->subDays(($i % 4) - 1)->setTime(8 + ($i % 9), ($i * 7) % 60);
                $isGraded = $i % 10 < 4; // 4 of every 7 submitters (~60%) already graded

                HomeworkSubmission::create([
                    'homework_id'  => $homework->id,
                    'student_id'   => $student->id,
                    'file_path'    => "homework-submissions/seed-placeholder-{$homework->id}-{$student->id}.pdf",
                    'file_name'    => 'assignment.pdf',
                    'submitted_at' => $submittedAt,
                    'score'        => $isGraded ? min(100, max(40, (int) round((random_int(50, 100) + random_int(50, 100)) / 2))) : null,
                    'feedback'     => $isGraded ? self::FEEDBACK_SAMPLES[$i % count(self::FEEDBACK_SAMPLES)] : null,
                    'graded_at'    => $isGraded ? $submittedAt->copy()->addDays(random_int(1, 3)) : null,
                ]);
            }
        }
    }
}
