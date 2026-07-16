<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\EnsuresClassOwnership;
use App\Models\Homework;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    use EnsuresClassOwnership;

    public function index()
    {
        $teacherId = Auth::user()->teacher->id;

        $homeworks = Homework::where('teacher_id', $teacherId)
            ->with(['schoolClass', 'subject'])
            ->latest('due_date')
            ->paginate(20);

        return view('teacher.homework', ['homeworks' => $homeworks]);
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;

        return view('teacher.homework-create', [
            'classes' => $teacher->classes,
            'subjects' => Subject::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $this->ensureTeacherOwnsClass($validated['class_id']);

        Homework::create([
            ...$validated,
            'teacher_id' => Auth::user()->teacher->id,
        ]);

        return redirect()->route('teacher.homework.index')
            ->with('status', 'Homework created.');
    }

    public function edit(Homework $homework)
    {
        $this->ensureTeacherOwnsClass($homework->class_id);

        $teacher = Auth::user()->teacher;

        return view('teacher.homework-edit', [
            'homework' => $homework,
            'classes' => $teacher->classes,
            'subjects' => Subject::all(),
        ]);
    }

    public function update(Request $request, Homework $homework)
    {
        $this->ensureTeacherOwnsClass($homework->class_id);

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        // If the class is being changed, confirm ownership of the NEW class too.
        $this->ensureTeacherOwnsClass($validated['class_id']);

        $homework->update($validated);

        return redirect()->route('teacher.homework.index')
            ->with('status', 'Homework updated.');
    }

    public function destroy(Homework $homework)
    {
        $this->ensureTeacherOwnsClass($homework->class_id);

        $homework->delete();

        return redirect()->route('teacher.homework.index')
            ->with('status', 'Homework deleted.');
    }
}
