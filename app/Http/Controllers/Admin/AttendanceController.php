<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ExportsAttendance;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use ExportsAttendance;

    public function index(Request $request)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $class = $classes->firstWhere('id', (int) $request->query('class')) ?? $classes->first();

        $students = collect();
        $marked = collect();
        $date = now()->toDateString();

        if ($class) {
            $students = Student::with('user')->where('class_id', $class->id)->orderBy('roll_no')->get();
            $marked = Attendance::where('class_id', $class->id)
                ->where('date', $date)
                ->pluck('status', 'student_id');
        }

        return view('admin.attendance', [
            'classes'      => $classes,
            'class'        => $class,
            'students'     => $students,
            'marked'       => $marked,
            'date'         => $date,
            'presentCount' => $marked->filter(fn ($s) => $s === 'present')->count(),
            'lateCount'    => $marked->filter(fn ($s) => $s === 'late')->count(),
            'absentCount'  => $marked->filter(fn ($s) => $s === 'absent')->count(),
        ]);
    }

    public function downloadAttendanceCsv(SchoolClass $class)
    {
        return $this->exportAttendanceCsv(...$this->resolveAttendanceExport($class));
    }

    public function downloadAttendancePdf(SchoolClass $class)
    {
        return $this->exportAttendancePdf(...$this->resolveAttendanceExport($class));
    }

    private function resolveAttendanceExport(SchoolClass $class): array
    {
        $date = now()->toDateString();
        $students = Student::with('user')->where('class_id', $class->id)->orderBy('roll_no')->get();
        $statusByStudentId = Attendance::where('class_id', $class->id)
            ->where('date', $date)
            ->pluck('status', 'student_id')
            ->all();

        return [$class, $date, $students, $statusByStudentId];
    }

    public function store(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'attendance'   => ['required', 'array'],
            'attendance.*' => ['nullable', 'in:present,late,absent'],
        ]);

        $date = now()->toDateString();

        foreach ($validated['attendance'] as $studentId => $status) {
            if (! $status) {
                continue;
            }

            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'class_id' => $class->id, 'date' => $date],
                ['status' => $status]
            );
        }

        return redirect()->route('admin.attendance.index', ['class' => $class->id])
            ->with('success', 'Attendance saved.');
    }
}
