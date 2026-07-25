<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Concerns\ExportsExamScores;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Notifications\ExamGradedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradebookController extends Controller
{
    use ExportsExamScores;

    public function index()
    {
        $teacher = Auth::user()->teacher;

        $exams = $teacher
            ? Exam::where('teacher_id', $teacher->id)
                ->with(['schoolClass', 'subject'])
                ->withCount('results')
                ->orderByDesc('exam_date')
                ->get()
            : collect();

        return view('teacher.gradebook', compact('exams'));
    }

    public function show(Exam $exam)
    {
        $this->authorizeExam($exam);

        $exam->load(['schoolClass', 'subject']);

        $students = Student::with('user')
            ->where('class_id', $exam->class_id)
            ->orderBy('roll_no')
            ->get();

        $scores = ExamResult::where('exam_id', $exam->id)->pluck('score', 'student_id');

        return view('teacher.gradebook-show', compact('exam', 'students', 'scores'));
    }

    public function store(Request $request, Exam $exam)
    {
        $this->authorizeExam($exam);

        $validated = $request->validate([
            'scores'   => ['required', 'array'],
            'scores.*' => ['nullable', 'integer', 'min:0', 'max:' . $exam->max_score],
        ]);

        foreach ($validated['scores'] as $studentId => $score) {
            if ($score === null || $score === '') {
                continue;
            }

            $result = ExamResult::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $studentId],
                ['score' => $score]
            );
            $result->setRelation('exam', $exam);

            $student = Student::with('user')->find($studentId);
            $student?->user?->notify(new ExamGradedNotification($result));
        }

        return redirect()->route('teacher.gradebook.show', $exam)->with('success', 'Scores saved.');
    }

    public function export(Exam $exam)
    {
        $this->authorizeExam($exam);

        return $this->exportExamScoresCsv($exam);
    }

    public function downloadGradebookPdf(Exam $exam)
    {
        $this->authorizeExam($exam);

        return $this->exportExamScoresPdf($exam);
    }

    // Exam-scoped, not class-scoped: a class's homeroom teacher and the
    // teacher who set a given exam aren't necessarily the same person, so
    // grading permission follows the exam's own teacher_id.
    private function authorizeExam(Exam $exam): void
    {
        abort_unless(
            Auth::user()->teacher && $exam->teacher_id === Auth::user()->teacher->id,
            403,
            'You do not have permission to grade this exam.'
        );
    }
}
