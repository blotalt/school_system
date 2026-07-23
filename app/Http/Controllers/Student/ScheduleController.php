<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Exam;
use App\Models\Student;

class ScheduleController extends Controller
{
    private const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    private const PERIOD_TIMES = [
        'morning' => [
            1 => '7:10 - 8:00',
            2 => '8:10 - 9:00',
            3 => '9:10 - 10:00',
            4 => '10:10 - 11:00',
        ],
        'afternoon' => [
            1 => '1:10 - 2:00',
            2 => '2:10 - 3:00',
            3 => '3:10 - 4:00',
            4 => '4:10 - 5:00',
        ],
    ];

    public function index()
    {
        $student = auth()->user()->student;
        $class   = $student?->schoolClass()->with('teacher.user')->first();

        $schedules = collect();
        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->where('status', 'approved')
                ->get()
                ->keyBy(fn($s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");
        }

        $exams = $student
            ? Exam::where('class_id', $student->class_id)
                ->with('subject')
                ->orderBy('exam_date')
                ->get()
            : collect();

        return view('student.schedule', [
            'student'     => $student,
            'class'       => $class,
            'schedules'   => $schedules,
            'exams'       => $exams,
            'days'        => self::DAYS,
            'periodTimes' => self::PERIOD_TIMES,
        ]);
    }

    public function showClass(ClassSchedule $schedule)
    {
        $student = auth()->user()->student;
        abort_unless($student && $schedule->class_id === $student->class_id, 403);

        $schedule->load(['subject', 'teacher.user', 'schoolClass']);

        $classmates = Student::with('user')
            ->where('class_id', $schedule->class_id)
            ->orderBy('roll_no')
            ->get();

        return view('student.view-class', compact('schedule', 'classmates'));
    }
}