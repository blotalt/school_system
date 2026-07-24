<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Exam;
use App\Models\Student;
use App\Support\Timetable;

class ScheduleController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // The student's class (with its homeroom teacher) is their schedule anchor.
        $class = $student?->schoolClass()->with('teacher.user')->first();

        // Upcoming exams for the student's class, read-only and self-scoped by class.
        $exams = $student
            ? Exam::where('class_id', $student->class_id)
                ->with('subject')
                ->orderBy('exam_date')
                ->get()
            : collect();

        // Weekly timetable grid for the student's own class, read-only.
        $schedules = collect();
        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->get()
                ->keyBy(fn (ClassSchedule $s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");
        }

        return view('student.schedule', [
            'student'     => $student,
            'class'       => $class,
            'exams'       => $exams,
            'schedules'   => $schedules,
            'days'        => Timetable::DAYS,
            'periodTimes' => Timetable::PERIOD_TIMES,
        ]);
    }

    public function showClass(ClassSchedule $schedule)
    {
        $student = auth()->user()->student;

        // Self-scoped: a student may only view a schedule slot for their own class.
        abort_unless($student && $schedule->class_id === $student->class_id, 403);

        $schedule->load(['subject', 'teacher.user', 'schoolClass']);

        $classmates = Student::with('user')
            ->where('class_id', $schedule->class_id)
            ->orderBy('roll_no')
            ->get();

        return view('student.view-class', compact('schedule', 'classmates'));
    }
}
