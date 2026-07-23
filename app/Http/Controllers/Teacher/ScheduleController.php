<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher;

        $classes = $teacher->assignedClasses()->orderBy('name')->get();

        if ($classes->isEmpty()) {
            return view('teacher.schedule', [
                'classes'     => collect(),
                'class'       => null,
                'subjects'    => collect(),
                'schedules'   => collect(),
                'teacher'     => $teacher,
                'days'        => self::DAYS,
                'periodTimes' => self::PERIOD_TIMES,
                'myPending'   => 0,
                'myRejected'  => 0,
            ]);
        }

        $subjects = $teacher->subjects()->orderBy('name')->get();

        $class = $classes->firstWhere('id', (int) $request->query('class')) ?? $classes->first();

        $schedules = collect();
        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->get()
                ->keyBy(fn($s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");
        }

        $myPending  = ClassSchedule::where('teacher_id', $teacher->id)->where('status', 'pending')->count();
        $myRejected = ClassSchedule::where('teacher_id', $teacher->id)->where('status', 'rejected')->count();

        return view('teacher.schedule', [
            'classes'     => $classes,
            'class'       => $class,
            'subjects'    => $subjects,
            'schedules'   => $schedules,
            'teacher'     => $teacher,
            'days'        => self::DAYS,
            'periodTimes' => self::PERIOD_TIMES,
            'myPending'   => $myPending,
            'myRejected'  => $myRejected,
        ]);
    }

    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;

        $validated = $request->validate([
            'class_id'    => ['required', 'exists:classes,id'],
            'subject_id'  => ['required', 'exists:subjects,id'],
            'day_of_week' => ['required', 'in:' . implode(',', self::DAYS)],
            'period'      => ['required', 'integer', 'min:1', 'max:4'],
            'shift'       => ['required', 'in:morning,afternoon'],
        ]);

        $existing = ClassSchedule::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('period', $validated['period'])
            ->where('shift', $validated['shift'])
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return back()->with('error', 'This slot is already taken or has a pending request.');
        }

        $teacherConflict = ClassSchedule::where('teacher_id', $teacher->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->where('period', $validated['period'])
            ->where('shift', $validated['shift'])
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($teacherConflict) {
            return back()->with('error', 'You already have a pending or approved slot at this time.');
        }

        ClassSchedule::create([
            ...$validated,
            'teacher_id' => $teacher->id,
            'status'     => 'pending',
        ]);

        return redirect()->route('teacher.schedule.index', ['class' => $validated['class_id']])
            ->with('success', 'Schedule request submitted. Waiting for admin approval.');
    }

    public function destroy(ClassSchedule $schedule)
    {
        $teacher = auth()->user()->teacher;
        abort_unless($schedule->teacher_id === $teacher->id, 403);
        abort_unless(in_array($schedule->status, ['pending', 'rejected']), 403);

        $classId = $schedule->class_id;
        $schedule->delete();

        return redirect()->route('teacher.schedule.index', ['class' => $classId])
            ->with('success', 'Schedule request removed.');
    }
}