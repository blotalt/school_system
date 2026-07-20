<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::orderBy('name')->get();

        $selectedClass = $request->filled('class_id')
            ? SchoolClass::findOrFail($request->class_id)
            : $classes->first();

        $date = $request->query('date', now()->toDateString());

        $students = $selectedClass
            ? $selectedClass->students()->with('user')->get()
            : collect();

        $records = $selectedClass
            ? Attendance::where('class_id', $selectedClass->id)
                ->where('date', $date)
                ->get()
                ->keyBy('student_id')
            : collect();

        $presentCount = $records->where('status', 'present')->count();
        $lateCount    = $records->where('status', 'late')->count();
        $absentCount  = $records->where('status', 'absent')->count();

        return view('admin.attendance', compact(
            'classes', 'selectedClass', 'students', 'records',
            'date', 'presentCount', 'lateCount', 'absentCount'
        ));
    }
}
