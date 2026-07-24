<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\ScheduleRequest;
use App\Models\SchoolClass;
use App\Models\User;
use App\Notifications\ScheduleRequestSubmittedNotification;
use App\Support\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher;

        $classes = $this->eligibleClasses($teacher?->id);
        $class = $classes->firstWhere('id', (int) $request->query('class')) ?? $classes->first();

        $subjects = $teacher?->subjects ?? collect();

        $schedules = collect();
        $pendingRequests = collect();

        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->get()
                ->keyBy(fn (ClassSchedule $s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");

            $pendingRequests = ScheduleRequest::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->where('status', 'pending')
                ->get()
                ->keyBy(fn (ScheduleRequest $r) => "{$r->shift}-{$r->day_of_week}-{$r->period}");
        }

        return view('teacher.schedule', [
            'classes'         => $classes,
            'class'           => $class,
            'subjects'        => $subjects,
            'schedules'       => $schedules,
            'pendingRequests' => $pendingRequests,
            'days'            => Timetable::DAYS,
            'periodTimes'     => Timetable::PERIOD_TIMES,
            'teacher'         => $teacher,
        ]);
    }

    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;
        abort_unless($teacher, 403);

        $validated = $request->validate([
            'class_id'    => ['required', 'exists:classes,id'],
            'subject_id'  => ['required', 'exists:subjects,id'],
            'day_of_week' => ['required', 'in:' . implode(',', Timetable::DAYS)],
            'period'      => ['required', 'integer', 'min:1', 'max:4'],
            'shift'       => ['required', 'in:morning,afternoon'],
        ]);

        $eligibleClassIds = $this->eligibleClasses($teacher->id)->pluck('id');
        abort_unless($eligibleClassIds->contains((int) $validated['class_id']), 403, 'You are not assigned to this class.');

        $subjectIds = $teacher->subjects->pluck('id');
        if (! $subjectIds->contains((int) $validated['subject_id'])) {
            throw ValidationException::withMessages([
                'subject_id' => 'You are not qualified to teach this subject.',
            ]);
        }

        $slotFilled = ClassSchedule::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('period', $validated['period'])
            ->where('shift', $validated['shift'])
            ->exists();

        if ($slotFilled) {
            throw ValidationException::withMessages([
                'period' => 'This slot is already filled.',
            ]);
        }

        $alreadyRequested = ScheduleRequest::where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('period', $validated['period'])
            ->where('shift', $validated['shift'])
            ->where('status', 'pending')
            ->exists();

        if ($alreadyRequested) {
            throw ValidationException::withMessages([
                'period' => 'This slot already has a pending request.',
            ]);
        }

        $scheduleRequest = ScheduleRequest::create([
            'class_id'    => $validated['class_id'],
            'subject_id'  => $validated['subject_id'],
            'teacher_id'  => $teacher->id,
            'day_of_week' => $validated['day_of_week'],
            'period'      => $validated['period'],
            'shift'       => $validated['shift'],
            'status'      => 'pending',
        ]);

        Notification::send(
            User::where('role', 'admin')->get(),
            new ScheduleRequestSubmittedNotification($scheduleRequest)
        );

        return redirect()->route('teacher.schedule.index', ['class' => $validated['class_id'], 'shift' => $validated['shift']])
            ->with('success', 'Schedule request submitted. Waiting for admin approval.');
    }

    public function destroy(ScheduleRequest $scheduleRequest)
    {
        $teacher = auth()->user()->teacher;

        abort_unless(
            $teacher && $scheduleRequest->teacher_id === $teacher->id && $scheduleRequest->status === 'pending',
            403
        );

        $classId = $scheduleRequest->class_id;
        $shift = $scheduleRequest->shift;
        $scheduleRequest->delete();

        return redirect()->route('teacher.schedule.index', ['class' => $classId, 'shift' => $shift])
            ->with('success', 'Request cancelled.');
    }

    /**
     * Classes this teacher may request slots for: their homeroom class(es),
     * any class where they already teach at least one approved period, and
     * any other class at the same grade level as those (e.g. a teacher in
     * Grade 10-A can also request slots in Grade 10-B/10-C).
     */
    private function eligibleClasses(?int $teacherId)
    {
        if (! $teacherId) {
            return collect();
        }

        $taughtClassIds = ClassSchedule::where('teacher_id', $teacherId)->pluck('class_id');
        $homeroomClassIds = SchoolClass::where('teacher_id', $teacherId)->pluck('id');
        $connectedClassIds = $homeroomClassIds->merge($taughtClassIds)->unique();

        $connectedGradeLevels = SchoolClass::whereIn('id', $connectedClassIds)
            ->pluck('grade_level')
            ->filter()
            ->unique();

        return SchoolClass::where(function ($query) use ($connectedClassIds, $connectedGradeLevels) {
                $query->whereIn('id', $connectedClassIds)
                    ->orWhereIn('grade_level', $connectedGradeLevels);
            })
            ->orderBy('name')
            ->get();
    }
}
