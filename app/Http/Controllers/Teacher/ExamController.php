<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    public function index()
    {
        $teacherId = auth()->user()->teacher->id;

        $exams = Exam::where('teacher_id', $teacherId)
            ->with(['schoolClass', 'subject'])
            ->withCount('results')
            ->orderByDesc('exam_date')
            ->get();

        return view('teacher.exams', compact('exams'));
    }

    public function create()
    {
        $teacher = auth()->user()->teacher;

        return view('teacher.exams-create', [
            'classes'  => $teacher->classes,
            'subjects' => $teacher->subjects()->orderBy('subjects.name')->get(),
        ]);
    }

    public function edit(Exam $exam)
    {
        abort_unless($exam->teacher_id === auth()->user()->teacher->id, 403);

        return view('teacher.exams-edit', ['exam' => $exam]);
    }

    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;
        $teacherSubjectIds = $teacher->subjects()->pluck('subjects.id');

        abort_if($teacherSubjectIds->isEmpty(), 403, 'You have no subject assigned. Contact an administrator.');

        $validated = $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'exam_type'  => 'required|in:monthly,semester',
            'title'      => 'required|string|max:255',
            'exam_date'  => 'required|date',
            'max_score'  => 'required|integer|min:1',
        ]);

        // Subject is derived from the teacher's own assignment, never trusted
        // from the request — a teacher can only examine what they teach.
        $validated['subject_id'] = $teacherSubjectIds->count() === 1
            ? $teacherSubjectIds->first()
            : $request->validate(['subject_id' => ['required', Rule::in($teacherSubjectIds)]])['subject_id'];

        $class = SchoolClass::findOrFail($validated['class_id']);
        abort_unless($class->teacher_id === $teacher->id, 403);

        Exam::create([
            ...$validated,
            'teacher_id' => $teacher->id,
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
