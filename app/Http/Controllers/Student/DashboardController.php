<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\ClassSchedule;
use App\Models\ExamResult;
use App\Models\Homework;

class DashboardController extends Controller
{
    private const PERIOD_TIMES = [
        1 => '7:10 - 8:00',
        2 => '8:10 - 9:00',
        3 => '9:10 - 10:00',
        4 => '10:10 - 11:00',
    ];

    public function index()
    {
        $student = auth()->user()->student;

        if (! $student) {
            // Ghost account (role=student but no student profile row). Fail soft.
            return view('student.dashboard', [
                'student'        => null,
                'class'          => null,
                'attendanceRate' => 0,
                'examCount'      => 0,
                'homeworkCount'  => 0,
                'announcements'  => collect(),
                'todaySchedule'  => collect(),
            ]);
        }

        $class = $student->schoolClass()->with('teacher.user')->first();

        // Attendance rate — self-scoped, divide-by-zero guarded.
        $total   = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $attendanceRate = $total > 0 ? round($present / $total * 100, 1) : 0;

        $examCount     = ExamResult::where('student_id', $student->id)->count();
        $homeworkCount = Homework::where('class_id', $student->class_id)->count();

        // Announcement feed: everyone/students + this student's class.
        $announcements = Announcement::visibleToStudent($student->class_id)
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        $todaySchedule = ClassSchedule::where('class_id', $student->class_id)
            ->where('day_of_week', now()->format('l'))
            ->with(['subject', 'teacher.user'])
            ->orderBy('shift')
            ->orderBy('period')
            ->get()
            ->map(fn (ClassSchedule $s) => (object) [
                'time'    => self::PERIOD_TIMES[$s->period] ?? '',
                'subject' => $s->subject->name,
                'teacher' => $s->teacher->user->name,
            ]);

        return view('student.dashboard', compact(
            'student', 'class', 'attendanceRate', 'examCount', 'homeworkCount', 'announcements', 'todaySchedule'
        ));
    }
}
