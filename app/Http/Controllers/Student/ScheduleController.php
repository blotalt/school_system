<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;

class ScheduleController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // The student's class (with its homeroom teacher) is their schedule anchor.
        $class = $student?->schoolClass()->with('teacher.user')->first();

        // Upcoming exams for the student's class, read-only and self-scoped by class.
        $exams = $student
            ? Exam::where('class_id', $student->class_id)
                ->with('subject')
                ->orderBy('exam_date')
                ->get()
            : collect();

        return view('student.schedule', compact('student', 'class', 'exams'));
    }
}
