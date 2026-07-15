<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\EnsuresClassOwnership;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    use EnsuresClassOwnership;

    public function index()
    {
        $teacherId = Auth::user()->teacher->id;

        $exams = Exam::where('teacher_id', $teacherId)
            ->with(['schoolClass', 'subject'])
            ->latest('exam_date')
            ->paginate(20);

        return view('teacher.exams', ['exams' => $exams]);
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;

        return view('teacher.exams-create', [
            'classes' => $teacher->classes,
            'subjects' => Subject::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|in:monthly,semester',
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'max_score' => 'required|integer|min:1',
        ]);

        $this->ensureTeacherOwnsClass($validated['class_id']);

        Exam::create([
            ...$validated,
            'teacher_id' => Auth::user()->teacher->id,
        ]);

        return redirect()->route('teacher.exams.index')
            ->with('status', 'Exam created.');
    }

    public function edit(Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $teacher = Auth::user()->teacher;

        return view('teacher.exams-edit', [
            'exam' => $exam,
            'classes' => $teacher->classes,
            'subjects' => Subject::all(),
        ]);
    }

    public function update(Request $request, Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|in:monthly,semester',
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'max_score' => 'required|integer|min:1',
        ]);

        $this->ensureTeacherOwnsClass($validated['class_id']);

        $exam->update($validated);

        return redirect()->route('teacher.exams.index')
            ->with('status', 'Exam updated.');
    }

    public function destroy(Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $exam->delete();

        return redirect()->route('teacher.exams.index')
            ->with('status', 'Exam deleted.');
    }
}
