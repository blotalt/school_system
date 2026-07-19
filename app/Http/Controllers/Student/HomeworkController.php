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

    public function show(Homework $homework)
    {
        $student = auth()->user()->student;

        // Self-scoped: a student may only view homework assigned to their own class.
        abort_unless($student && $homework->class_id === $student->class_id, 403);

        $homework->load(['subject', 'teacher.user', 'schoolClass']);

        return view('student.view-task', compact('homework'));
    }
}
