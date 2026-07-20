<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['schoolClass', 'subject', 'teacher.user'])
            ->latest()
            ->paginate(20);

        return view('admin.exams', compact('exams'));
    }

    public function show(Exam $exam)
    {
        $exam->load(['schoolClass', 'subject', 'teacher.user', 'results.student.user']);

        return view('admin.exams-results', compact('exam'));
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted.');
    }
}
