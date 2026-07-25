<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    private const SUBMISSION_RULES = ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'];

    public function index()
    {
        $student = auth()->user()->student;

        // Self-scoped to the student's own class.
        $homeworks = $student
            ? Homework::where('class_id', $student->class_id)
                ->with('subject')
                ->orderBy('due_date')
                ->get()
            : collect();

        $submissions = $student
            ? HomeworkSubmission::where('student_id', $student->id)->get()->keyBy('homework_id')
            : collect();

        return view('student.homework', compact('student', 'homeworks', 'submissions'));
    }

    public function show(Homework $homework)
    {
        $student = auth()->user()->student;

        // Self-scoped: a student may only view homework assigned to their own class.
        abort_unless($student && $homework->class_id === $student->class_id, 403);

        $homework->load(['subject', 'teacher.user', 'schoolClass']);

        $submission = HomeworkSubmission::where('homework_id', $homework->id)
            ->where('student_id', $student->id)
            ->first();

        return view('student.view-task', compact('homework', 'submission'));
    }

    public function submit(Request $request, Homework $homework)
    {
        $student = auth()->user()->student;

        // Self-scoped: a student may only submit to homework assigned to their own class.
        abort_unless($student && $homework->class_id === $student->class_id, 403);

        $validated = $request->validate(['submission' => self::SUBMISSION_RULES]);

        $existing = HomeworkSubmission::where('homework_id', $homework->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->file_path);
        }

        $file = $request->file('submission');

        HomeworkSubmission::updateOrCreate(
            ['homework_id' => $homework->id, 'student_id' => $student->id],
            [
                'file_path'    => $file->store('homework-submissions', 'public'),
                'file_name'    => $file->getClientOriginalName(),
                'submitted_at' => now(),
                // A new file always needs fresh grading, whether this is the
                // first submission or a resubmission of an already-graded one.
                'score'        => null,
                'feedback'     => null,
                'graded_at'    => null,
            ]
        );

        return redirect()->route('student.view-task', $homework)
            ->with('success', 'Your work has been submitted.');
    }
}
