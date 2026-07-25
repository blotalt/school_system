<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\TeacherAvailability;
use App\Support\Timetable;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
   public function index()
{
    $teacher = auth()->user()->teacher;

    $mySchedules = $teacher
        ? ClassSchedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacher->id)
            ->get()
            ->keyBy(fn($s) => "{$s->shift}-{$s->day_of_week}-{$s->period}")
        : collect();

    $availability = $teacher
        ? TeacherAvailability::where('teacher_id', $teacher->id)
            ->get()
            ->keyBy(fn($a) => "{$a->shift}-{$a->day_of_week}-{$a->period}")
        : collect();

    $uniqueClasses = $mySchedules->values()
        ->map(fn($s) => $s->schoolClass)->filter()->unique('id')->values();

    $scheduleApproved = $uniqueClasses->isNotEmpty()
        && $uniqueClasses->every(fn($c) => !is_null($c->schedule_approved_at));

    return view('teacher.schedule', [
        'mySchedules'     => $mySchedules,
        'availability'    => $availability,
        'days'            => Timetable::DAYS,
        'periodTimes'     => Timetable::PERIOD_TIMES,
        'teacher'         => $teacher,
        'scheduleApproved' => $scheduleApproved,
    ]);
}

    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;
        abort_unless($teacher, 403);

        $data = $request->input('availability', []);
        $valid = ['available', 'preferred', 'unavailable'];

        foreach (Timetable::DAYS as $day) {
            foreach (['morning', 'afternoon'] as $shift) {
                for ($period = 1; $period <= 4; $period++) {
                    $status = $data[$shift][$day][$period] ?? 'unavailable';
                    if (!in_array($status, $valid)) {
                        $status = 'unavailable';
                    }

                    TeacherAvailability::updateOrCreate(
                        [
                            'teacher_id'  => $teacher->id,
                            'day_of_week' => $day,
                            'period'      => $period,
                            'shift'       => $shift,
                        ],
                        ['status' => $status]
                    );
                }
            }
        }

        return redirect()->route('teacher.schedule.index')
            ->with('success', 'Availability saved successfully.');
    }
}