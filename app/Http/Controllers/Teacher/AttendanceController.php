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
        $students = $class->students;
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
            'attendance.*' => 'required|in:present,absent,late',
        ]);

        foreach ($validated['attendance'] as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $class->id,
                    'date' => $validated['date'],
                ],
                ['status' => $status]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved.');
    }
    
}