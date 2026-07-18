<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (! $teacher) {
            return view('teacher.dashboard', [
                'teacher'        => null,
                'classes'        => collect(),
                'studentCount'   => 0,
                'examCount'      => 0,
                'attendanceRate' => 0,
                'announcements'  => collect(),
            ]);
        }

        // Scoped: ONLY this teacher's classes — not system-wide totals.
        $classes  = SchoolClass::where('teacher_id', $teacher->id)->withCount('students')->get();
        $classIds = $classes->pluck('id');

        $studentCount = Student::whereIn('class_id', $classIds)->count();
        $examCount    = Exam::where('teacher_id', $teacher->id)->count();

        $total   = Attendance::whereIn('class_id', $classIds)->count();
        $present = Attendance::whereIn('class_id', $classIds)->where('status', 'present')->count();
        $attendanceRate = $total > 0 ? round($present / $total * 100, 1) : 0;

        $announcements = Announcement::visibleToTeacher()
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'teacher', 'classes', 'studentCount', 'examCount', 'attendanceRate', 'announcements'
        ));
    }
}
