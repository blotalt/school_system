<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\EnsuresClassOwnership;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class GradebookController extends Controller
{
    use EnsuresClassOwnership;

    public function show(Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $class    = $exam->schoolClass;
        $students = $class->students()->with('user')->get();
        $results  = $exam->results->keyBy('student_id');

        return view('teacher.gradebook', compact('exam', 'class', 'students', 'results'));
    }

    public function store(Request $request, Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $validated = $request->validate([
            'scores'   => 'required|array',
            'scores.*' => 'required|integer|min:0|max:' . $exam->max_score,
        ]);

        foreach ($validated['scores'] as $studentId => $score) {
            ExamResult::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $studentId],
                ['score' => $score]
            );
        }

        return redirect()->back()->with('success', 'Scores saved.');
    }
}
