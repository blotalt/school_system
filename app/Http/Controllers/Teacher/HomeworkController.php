<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\EnsuresClassOwnership;
use App\Models\Homework;
use App\Models\Subject;
use App\Models\User;
use App\Notifications\HomeworkAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    use EnsuresClassOwnership;

    private const ATTACHMENT_RULES = ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'];

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
            'attachment' => self::ATTACHMENT_RULES,
        ]);

        $this->ensureTeacherOwnsClass($validated['class_id']);

        $attachment = $this->storeAttachment($request);

        $homework = Homework::create([
            ...$validated,
            'teacher_id' => Auth::user()->teacher->id,
            'attachment_path' => $attachment['path'] ?? null,
            'attachment_name' => $attachment['name'] ?? null,
        ]);

        $students = User::where('role', 'student')
            ->whereHas('student', fn ($q) => $q->where('class_id', $homework->class_id))
            ->get();

        Notification::send($students, new HomeworkAssignedNotification($homework));

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
            'attachment' => self::ATTACHMENT_RULES,
            'remove_attachment' => 'nullable|boolean',
        ]);

        // If the class is being changed, confirm ownership of the NEW class too.
        $this->ensureTeacherOwnsClass($validated['class_id']);

        $attachment = $this->storeAttachment($request);

        if ($attachment || $request->boolean('remove_attachment')) {
            if ($homework->attachment_path) {
                Storage::disk('public')->delete($homework->attachment_path);
            }

            $validated['attachment_path'] = $attachment['path'] ?? null;
            $validated['attachment_name'] = $attachment['name'] ?? null;
        }

        unset($validated['remove_attachment']);

        $homework->update($validated);

        return redirect()->route('teacher.homework.index')
            ->with('status', 'Homework updated.');
    }

    public function destroy(Homework $homework)
    {
        $this->ensureTeacherOwnsClass($homework->class_id);

        if ($homework->attachment_path) {
            Storage::disk('public')->delete($homework->attachment_path);
        }

        $homework->delete();

        return redirect()->route('teacher.homework.index')
            ->with('status', 'Homework deleted.');
    }

    private function storeAttachment(Request $request): ?array
    {
        if (! $request->hasFile('attachment')) {
            return null;
        }

        $file = $request->file('attachment');

        return [
            'path' => $file->store('homework-attachments', 'public'),
            'name' => $file->getClientOriginalName(),
        ];
    }
}
