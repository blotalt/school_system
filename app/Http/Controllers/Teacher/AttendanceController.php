<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\EnsuresClassOwnership;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use EnsuresClassOwnership;

    public function show(SchoolClass $class, Request $request)
    {
        $this->ensureTeacherOwnsClass($class->id);

        $date = $request->query('date', now()->toDateString());
        $students = $class->students()->with('user')->orderBy('roll_no')->get();
        $records = Attendance::where('class_id', $class->id)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance', compact('class', 'students', 'records', 'date'));
    }

    public function store(Request $request, SchoolClass $class)
    {
        $this->ensureTeacherOwnsClass($class->id);

        $validated = $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'nullable|in:present,absent,late',
        ]);

        foreach ($validated['attendance'] as $studentId => $status) {
            if (! $status) {
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $class->id,
                    'date' => $validated['date'],
                ],
                ['status' => $status]
            );
        }

        return redirect()->route('teacher.attendance.show', $class)->with('success', 'Attendance saved.');
    }
}