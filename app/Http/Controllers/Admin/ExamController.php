<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $classId = $request->query('class');

        $exams = Exam::with(['schoolClass', 'subject', 'teacher.user'])
            ->when($classId, fn ($query) => $query->where('class_id', $classId))
            ->withCount('results')
            ->orderByDesc('exam_date')
            ->paginate(20)
            ->withQueryString();

        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.exams', compact('exams', 'classes', 'classId'));
    }

    public function create()
    {
        return view('admin.exams-create', [
            'classes'  => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::with('user')->get()->sortBy(fn (Teacher $t) => $t->user->name)->values(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id'   => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'exam_type'  => ['required', 'in:monthly,semester'],
            'title'      => ['required', 'string', 'max:255'],
            'exam_date'  => ['required', 'date'],
            'max_score'  => ['required', 'integer', 'min:1'],
        ]);

        Exam::create($validated);

        return redirect()->route('admin.exams.index')->with('success', 'Exam created.');
    }

    public function edit(Exam $exam)
    {
        return view('admin.exams-edit', [
            'exam'     => $exam,
            'classes'  => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::with('user')->get()->sortBy(fn (Teacher $t) => $t->user->name)->values(),
        ]);
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'class_id'   => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'exam_type'  => ['required', 'in:monthly,semester'],
            'title'      => ['required', 'string', 'max:255'],
            'exam_date'  => ['required', 'date'],
            'max_score'  => ['required', 'integer', 'min:1'],
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated.');
    }

    public function destroy(Exam $exam)
    {
        DB::transaction(function () use ($exam) {
            $exam->results()->delete();
            $exam->delete();
        });

        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted.');
    }

    public function results(Exam $exam)
    {
        $exam->load(['schoolClass', 'subject', 'teacher.user']);

        $students = Student::with('user')
            ->where('class_id', $exam->class_id)
            ->orderBy('roll_no')
            ->get();

        $scores = ExamResult::where('exam_id', $exam->id)->pluck('score', 'student_id');

        $average = $scores->isNotEmpty() ? round($scores->avg(), 1) : null;

        return view('admin.exams-results', compact('exam', 'students', 'scores', 'average'));
    }

    public function storeResults(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'scores'   => ['required', 'array'],
            'scores.*' => ['nullable', 'integer', 'min:0', 'max:' . $exam->max_score],
        ]);

        foreach ($validated['scores'] as $studentId => $score) {
            if ($score === null || $score === '') {
                continue;
            }

            ExamResult::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $studentId],
                ['score' => $score]
            );
        }

        return redirect()->route('admin.exams.results.index', $exam)->with('success', 'Scores saved.');
    }
}
