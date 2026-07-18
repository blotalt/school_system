<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;

class GradeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // Self-scoped: only ever fetch THIS student's results. Never leaves the DB otherwise.
        $results = $student
            ? ExamResult::where('student_id', $student->id)
                ->with('exam.subject')
                ->get()
            : collect();

        return view('student.grades', compact('student', 'results'));
    }
}
