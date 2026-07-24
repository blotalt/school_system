<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Concerns\ExportsTables;
use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    use ExportsTables;

    private const ATTENDANCE_HEADERS = ['Date', 'Status'];

    public function index()
    {
        $student = auth()->user()->student;

        // Self-scoped: a student sees only their own attendance history.
        $records = $student
            ? Attendance::where('student_id', $student->id)
                ->orderByDesc('date')
                ->get()
            : collect();

        // Simple rate summary (guard against divide-by-zero on empty history).
        $total   = $records->count();
        $present = $records->where('status', 'present')->count();
        $rate    = $total > 0 ? round($present / $total * 100, 1) : 0;

        return view('student.attendance', compact('student', 'records', 'total', 'present', 'rate'));
    }

    public function exportAttendanceCsv()
    {
        return $this->exportCsv('my-attendance.csv', self::ATTENDANCE_HEADERS, $this->attendanceRows());
    }

    public function exportAttendancePdf()
    {
        return $this->exportPdf('my-attendance.pdf', 'My Attendance', self::ATTENDANCE_HEADERS, $this->attendanceRows());
    }

    // Self-scoped: only ever builds rows from THIS student's own attendance history.
    private function attendanceRows()
    {
        $student = auth()->user()->student;

        if (! $student) {
            return collect();
        }

        return Attendance::where('student_id', $student->id)
            ->orderByDesc('date')
            ->get()
            ->map(fn (Attendance $record) => [
                $record->date->format('M d, Y'),
                ucfirst($record->status),
            ]);
    }
}
