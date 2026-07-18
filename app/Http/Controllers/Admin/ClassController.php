<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
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
        $classes = SchoolClass::orderBy('name')->get();
        $class = $classes->firstWhere('id', (int) $request->query('class')) ?? $classes->first();

        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::with('user')->get()->sortBy(fn (Teacher $t) => $t->user->name)->values();

        $schedules = collect();
        if ($class) {
            $schedules = ClassSchedule::with(['subject', 'teacher.user'])
                ->where('class_id', $class->id)
                ->get()
                ->keyBy(fn (ClassSchedule $s) => "{$s->shift}-{$s->day_of_week}-{$s->period}");
        }

        return view('admin.classes', [
            'classes'     => $classes,
            'class'       => $class,
            'subjects'    => $subjects,
            'teachers'    => $teachers,
            'schedules'   => $schedules,
            'days'        => self::DAYS,
            'periodTimes' => self::PERIOD_TIMES,
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
            'day_of_week' => ['required', 'in:' . implode(',', self::DAYS)],
            'period'      => ['required', 'integer', 'min:1', 'max:4'],
            'shift'       => ['required', 'in:morning,afternoon'],
        ]);

        $conflict = ClassSchedule::with(['teacher.user', 'schoolClass'])
            ->where('teacher_id', $validated['teacher_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('period', $validated['period'])
            ->where('shift', $validated['shift'])
            ->where('class_id', '!=', $class->id)
            ->first();

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

        return redirect()->route('admin.classes.index', ['class' => $class->id, 'shift' => $validated['shift']])
            ->with('success', 'Schedule updated.');
    }

    public function destroySchedule(SchoolClass $class, ClassSchedule $schedule)
    {
        $shift = $schedule->shift;
        $schedule->delete();

        return redirect()->route('admin.classes.index', ['class' => $class->id, 'shift' => $shift])
            ->with('success', 'Slot cleared.');
    }
}
