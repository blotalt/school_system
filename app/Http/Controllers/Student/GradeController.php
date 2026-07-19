<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ExamResult;

class GradeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        if (! $student) {
            return view('student.grades', [
                'student' => null, 'class' => null, 'results' => collect(),
                'attendanceRate' => 0, 'averageScore' => null,
            ]);
        }

        $class = $student->schoolClass()->with('teacher.user')->first();

        // Self-scoped: only ever fetch THIS student's results. Never leaves the DB otherwise.
        $results = ExamResult::where('student_id', $student->id)
            ->with('exam.subject')
            ->latest()
            ->get();

        $percentages = $results->map(fn (ExamResult $r) => $r->exam->max_score > 0
            ? $r->score / $r->exam->max_score * 100
            : null)->filter();
        $averageScore = $percentages->isNotEmpty() ? round($percentages->avg(), 1) : null;

        $total   = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $attendanceRate = $total > 0 ? round($present / $total * 100, 1) : 0;

        return view('student.grades', compact('student', 'class', 'results', 'attendanceRate', 'averageScore'));
    }
}
