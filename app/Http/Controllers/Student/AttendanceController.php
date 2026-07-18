<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AttendanceController extends Controller
{
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
}
