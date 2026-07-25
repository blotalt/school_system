<?php

namespace Database\Seeders;

use App\Models\Homework;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

/**
 * 2 assignments for each of a class's 3 most-frequently-taught subjects
 * (its real timetable), due dates spread across past/present/future for
 * status variety (overdue, due soon, upcoming).
 */
class HomeworkSeeder extends Seeder
{
    private const TITLE_TEMPLATES = [
        'Chapter :n Practice Problems',
        'Reading Reflection: Unit :n',
        'Worksheet Review :n',
        ':subject Homework :n',
    ];

    public function run(): void
    {
        $classes = SchoolClass::with('schedules.subject')->get();
        $dueOffsets = [-10, -3, 5, 12, 21, 30]; // mix of overdue, due-soon, upcoming

        $globalIndex = 0;

        foreach ($classes as $class) {
            $bySubject = $class->schedules->groupBy('subject_id');
            $topSubjects = $bySubject->sortByDesc(fn ($rows) => $rows->count())->take(3);

            foreach ($topSubjects as $subjectId => $rows) {
                $subject = $rows->first()->subject;
                $teacherId = $rows->first()->teacher_id;

                for ($n = 1; $n <= 2; $n++) {
                    $template = self::TITLE_TEMPLATES[$globalIndex % count(self::TITLE_TEMPLATES)];
                    $title = str_replace([':n', ':subject'], [$n, $subject->name], $template);
                    $dueDate = now()->addDays($dueOffsets[$globalIndex % count($dueOffsets)])->toDateString();

                    Homework::create([
                        'class_id'    => $class->id,
                        'teacher_id'  => $teacherId,
                        'subject_id'  => $subjectId,
                        'title'       => $title,
                        'description' => "Complete {$title} for {$subject->name} and submit before the due date.",
                        'due_date'    => $dueDate,
                    ]);

                    $globalIndex++;
                }
            }
        }
    }
}
