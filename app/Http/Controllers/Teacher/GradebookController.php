<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\EnsuresClassOwnership;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradebookController extends Controller
{
    use EnsuresClassOwnership;

    /**
     * Show the gradebook grid for one exam: every student in that exam's
     * class, plus their existing score if one was already entered.
     */
    public function show(Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $students = $exam->schoolClass->students;

        // Keyed by student_id so the Blade grid can look up each student's
        // current score in O(1) instead of searching a flat list.
        $results = $exam->results->keyBy('student_id');

        return view('teacher.gradebook', [
            'exam' => $exam,
            'students' => $students,
            'results' => $results,
        ]);
    }

    /**
     * Save the whole grid in one submission.
     * Expects: scores[student_id] = score  (array-keyed by student id -
     * this exact shape must match what F2's grid form sends).
     */
    public function store(Request $request, Exam $exam)
    {
        $this->ensureTeacherOwnsClass($exam->class_id);

        $validated = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|integer|min:0|max:' . $exam->max_score,
        ]);

        DB::transaction(function () use ($validated, $exam) {
            foreach ($validated['scores'] as $studentId => $score) {
                if ($score === null || $score === '') {
                    continue;
                }

                // updateOrCreate + the unique(exam_id, student_id) constraint
                // together mean re-submitting the grid corrects a score
                // instead of creating a duplicate result row.
                ExamResult::updateOrCreate(
                    ['exam_id' => $exam->id, 'student_id' => $studentId],
                    ['score' => $score]
                );
            }
        });

        return redirect()->route('teacher.gradebook.show', $exam)
            ->with('status', 'Scores saved.');
    }
}
