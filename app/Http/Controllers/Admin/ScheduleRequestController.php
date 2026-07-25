<!-- <?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\ScheduleRequest;
use App\Models\Teacher;
use App\Models\TeacherAvailability;
use App\Notifications\ScheduleRequestDecidedNotification;
use App\Support\Timetable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleRequestController extends Controller
{
public function index(Request $request)
{
    $teachers = Teacher::with(['user', 'availability', 'subjects'])->get()
        ->sortBy(fn($t) => $t->user->name)
        ->values();

    $availabilityMap = TeacherAvailability::all()
        ->groupBy('teacher_id')
        ->map(fn($items) => $items
            ->keyBy(fn($a) => "{$a->shift}-{$a->day_of_week}-{$a->period}")
            ->map->status
        );

    return view('admin.schedule-requests', [
        'teachers'        => $teachers,
        'availabilityMap' => $availabilityMap,
        'days'            => \App\Support\Timetable::DAYS,
        'periodTimes'     => \App\Support\Timetable::PERIOD_TIMES,
    ]);
}

    public function approve(ScheduleRequest $scheduleRequest)
    {
        abort_unless($scheduleRequest->status === 'pending', 404);

        $conflict = Timetable::teacherConflict(
            $scheduleRequest->teacher_id,
            $scheduleRequest->day_of_week,
            $scheduleRequest->period,
            $scheduleRequest->shift,
            $scheduleRequest->class_id
        );

        if ($conflict) {
            throw ValidationException::withMessages([
                'teacher_id' => "{$conflict->teacher->user->name} is already teaching {$conflict->schoolClass->name} at this time.",
            ]);
        }

        $slotFilled = ClassSchedule::where('class_id', $scheduleRequest->class_id)
            ->where('day_of_week', $scheduleRequest->day_of_week)
            ->where('period', $scheduleRequest->period)
            ->where('shift', $scheduleRequest->shift)
            ->exists();

        if ($slotFilled) {
            throw ValidationException::withMessages([
                'period' => 'That slot has already been filled since this request was submitted.',
            ]);
        }

        ClassSchedule::create([
            'class_id'    => $scheduleRequest->class_id,
            'subject_id'  => $scheduleRequest->subject_id,
            'teacher_id'  => $scheduleRequest->teacher_id,
            'day_of_week' => $scheduleRequest->day_of_week,
            'period'      => $scheduleRequest->period,
            'shift'       => $scheduleRequest->shift,
        ]);

        $scheduleRequest->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $scheduleRequest->teacher->user->notify(new ScheduleRequestDecidedNotification($scheduleRequest));

        return redirect()->route('admin.schedule-requests.index')->with('success', 'Request approved.');
    }

    public function reject(ScheduleRequest $scheduleRequest)
    {
        abort_unless($scheduleRequest->status === 'pending', 404);

        $scheduleRequest->update([
            'status'      => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $scheduleRequest->teacher->user->notify(new ScheduleRequestDecidedNotification($scheduleRequest));

        return redirect()->route('admin.schedule-requests.index')->with('success', 'Request rejected.');
    }
} -->