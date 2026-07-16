<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $teacherId = auth()->user()->teacher->id;

        $exams = Exam::where('teacher_id', $teacherId)
            ->with(['schoolClass', 'subject'])
            ->get();

        return view('teacher.exams', compact('exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type'  => 'required|in:monthly,semester',
            'title'      => 'required|string|max:255',
            'exam_date'  => 'required|date',
            'max_score'  => 'required|integer|min:1',
        ]);

        $class = SchoolClass::findOrFail($validated['class_id']);
        abort_unless($class->teacher_id === auth()->user()->teacher->id, 403);

        Exam::create([
            ...$validated,
            'teacher_id' => auth()->user()->teacher->id,
        ]);

        return redirect()->route('teacher.exams.index')->with('success', 'Exam created.');
    }

    public function update(Request $request, Exam $exam)
    {
        abort_unless($exam->teacher_id === auth()->user()->teacher->id, 403);

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'exam_date' => 'required|date',
            'max_score' => 'required|integer|min:1',
        ]);

        $exam->update($validated);

        return redirect()->route('teacher.exams.index')->with('success', 'Exam updated.');
    }

    public function destroy(Exam $exam)
    {
        abort_unless($exam->teacher_id === auth()->user()->teacher->id, 403);

        $exam->delete();

        return redirect()->route('teacher.exams.index')->with('success', 'Exam deleted.');
    }
}