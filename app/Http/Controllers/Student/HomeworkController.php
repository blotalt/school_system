<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;

class HomeworkController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        // Self-scoped to the student's own class. Read-only — students view, never submit.
        $homeworks = $student
            ? Homework::where('class_id', $student->class_id)
                ->with('subject')
                ->orderBy('due_date')
                ->get()
            : collect();

        return view('student.homework', compact('student', 'homeworks'));
    }
}
