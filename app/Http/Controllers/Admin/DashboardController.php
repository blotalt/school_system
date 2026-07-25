<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        // Top-line counts (system-wide for admin).
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $activeClasses = SchoolClass::count();

        // School-wide attendance rate — divide-by-zero guarded.
        $total   = Attendance::count();
        $present = Attendance::where('status', 'present')->count();
        $attendanceRate = $total > 0 ? round($present / $total * 100, 1) : 0;

        $stats = [
            ['icon' => 'fa-user-graduate',  'value' => number_format($totalStudents), 'label' => __('admin.dashboard.stat_total_students')],
            ['icon' => 'fa-chalkboard-user','value' => number_format($totalTeachers), 'label' => __('admin.dashboard.stat_total_teachers')],
            ['icon' => 'fa-circle-check',   'value' => $attendanceRate . '%',         'label' => __('admin.dashboard.stat_attendance_rate')],
            ['icon' => 'fa-school',         'value' => number_format($activeClasses), 'label' => __('admin.dashboard.stat_active_classes')],
        ];

        // Classes overview — eager-load student counts and per-class attendance in
        // aggregate queries (no N+1 loop over classes).
        $attendanceByClass = Attendance::selectRaw(
            "class_id, COUNT(*) as total, SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present"
        )->groupBy('class_id')->get()->keyBy('class_id');

        $classes = SchoolClass::withCount('students')->get()->map(function ($class) use ($attendanceByClass) {
            $row  = $attendanceByClass->get($class->id);
            $rate = ($row && $row->total > 0) ? round($row->present / $row->total * 100, 1) : 0;

            $class->computed_attendance = $rate;
            return $class;
        });

        return view('admin.dashboard', compact('stats', 'classes'));
    }
}