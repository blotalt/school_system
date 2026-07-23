<?php

namespace App\Http\Controllers\Admin;

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
        $pending = ClassSchedule::with(['schoolClass', 'subject', 'teacher.user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $classes = SchoolClass::orderBy('name')->get();
        $class   = $classes->firstWhere('id', (int) $request->query('class')) ?? $classes->first();

        $schedules = collect();
        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->where('status', 'approved')
                ->get()
                ->keyBy(fn($s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");
        }

        return view('admin.schedule', [
            'pending'     => $pending,
            'classes'     => $classes,
            'class'       => $class,
            'schedules'   => $schedules,
            'days'        => self::DAYS,
            'periodTimes' => self::PERIOD_TIMES,
        ]);
    }

    public function approve(ClassSchedule $schedule)
    {
        $conflict = ClassSchedule::where('teacher_id', $schedule->teacher_id)
            ->where('day_of_week', $schedule->day_of_week)
            ->where('period', $schedule->period)
            ->where('shift', $schedule->shift)
            ->where('status', 'approved')
            ->where('id', '!=', $schedule->id)
            ->first();

        if ($conflict) {

            return back()->with('error', "Teacher already has an approved slot at this time ({$conflict->schoolClass->name}).");
        }

        $schedule->update(['status' => 'approved', 'rejection_note' => null]);

        return back()->with('success', 'Schedule approved.');
    }

    public function reject(Request $request, ClassSchedule $schedule)
    {
        $request->validate([
            'rejection_note' => ['nullable', 'string', 'max:500'],
        ]);

        $schedule->update([
            'status'         => 'rejected',
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Schedule rejected.');
    }

    public function destroy(ClassSchedule $schedule)
{
    $schedule->delete();
    return back()->with('success', 'Schedule slot removed.');
}
}