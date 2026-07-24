<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Support\Timetable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $class   = $classes->firstWhere('id', (int) $request->query('class')) ?? $classes->first();

        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with(['user', 'subjects'])->get()
            ->sortBy(fn(Teacher $t) => $t->user->name)
            ->values();

        $schedules = collect();
        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->get()
                ->keyBy(fn(ClassSchedule $s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");
        }

        $availabilityMap = \App\Models\TeacherAvailability::all()
            ->groupBy('teacher_id')
            ->map(fn($items) => $items
                ->keyBy(fn($a) => "{$a->shift}-{$a->day_of_week}-{$a->period}")
                ->map->status
            );

        $allAssignedSlots = ClassSchedule::all()
            ->groupBy('teacher_id')
            ->map(fn($items) => $items
                ->map(fn($s) => "{$s->shift}-{$s->day_of_week}-{$s->period}")
                ->values()
            );

        $teacherData = $teachers->map(fn($t) => [
            'id'        => $t->id,
            'name'      => $t->user->name,
            'firstname' => explode(' ', $t->user->name)[0],
            'specialty' => $t->subject_specialty ?? '',
            'subjects'  => $t->subjects->pluck('id')->values()->all(),
        ])->values();

        return view('admin.classes', [
            'classes'          => $classes,
            'class'            => $class,
            'subjects'         => $subjects,
            'teachers'         => $teachers,
            'schedules'        => $schedules,
            'days'             => Timetable::DAYS,
            'periodTimes'      => Timetable::PERIOD_TIMES,
            'availabilityMap'  => $availabilityMap,
            'allAssignedSlots' => $allAssignedSlots,
            'teacherData'      => $teacherData,
        ]);
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classes-create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'track'       => ['nullable', 'string', 'max:255'],
            'grade_level' => ['nullable', 'string', 'max:255'],
            'teacher_id'  => ['nullable', 'exists:teachers,id'],
        ]);

        SchoolClass::create($request->only('name', 'track', 'grade_level', 'teacher_id'));

        return redirect()->route('admin.classes.index')->with('success', 'Class created.');
    }

    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classes-edit', compact('class', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'track'       => ['nullable', 'string', 'max:255'],
            'grade_level' => ['nullable', 'string', 'max:255'],
            'teacher_id'  => ['nullable', 'exists:teachers,id'],
        ]);

        $class->update($request->only('name', 'track', 'grade_level', 'teacher_id'));

        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted.');
    }

    public function storeSchedule(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'subject_id'  => ['required', 'exists:subjects,id'],
            'teacher_id'  => ['required', 'exists:teachers,id'],
            'day_of_week' => ['required', 'in:' . implode(',', Timetable::DAYS)],
            'period'      => ['required', 'integer', 'min:1', 'max:4'],
            'shift'       => ['required', 'in:morning,afternoon'],
        ]);

        $conflict = Timetable::teacherConflict(
            $validated['teacher_id'],
            $validated['day_of_week'],
            $validated['period'],
            $validated['shift'],
            $class->id
        );

        if ($conflict) {
            throw ValidationException::withMessages([
                'teacher_id' => "{$conflict->teacher->user->name} is already teaching {$conflict->schoolClass->name} at this time.",
            ]);
        }

        ClassSchedule::updateOrCreate(
            [
                'class_id'    => $class->id,
                'day_of_week' => $validated['day_of_week'],
                'period'      => $validated['period'],
                'shift'       => $validated['shift'],
            ],
            [
                'subject_id' => $validated['subject_id'],
                'teacher_id' => $validated['teacher_id'],
            ]
        );

        $class->update(['schedule_approved_at' => null]);

        return redirect()->route('admin.classes.index', ['class' => $class->id, 'shift' => $validated['shift']])
            ->with('success', 'Slot assigned.');
    }

    public function destroySchedule(SchoolClass $class, ClassSchedule $schedule)
    {
        $shift = $schedule->shift;
        $schedule->delete();
        $class->update(['schedule_approved_at' => null]);

        return redirect()->route('admin.classes.index', ['class' => $class->id, 'shift' => $shift])
            ->with('success', 'Slot cleared.');
    }

    public function approveSchedule(SchoolClass $class)
    {
        $class->update(['schedule_approved_at' => now()]);

        return redirect()->route('admin.classes.index', ['class' => $class->id])
            ->with('success', "Schedule for {$class->name} approved and published to teachers.");
    }

    public function unapproveSchedule(SchoolClass $class)
    {
        $class->update(['schedule_approved_at' => null]);

        return redirect()->route('admin.classes.index', ['class' => $class->id])
            ->with('success', "Schedule for {$class->name} reverted to draft.");
    }
}