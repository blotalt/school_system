<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SchoolClass;
use App\Models\User;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        // Optional audience filter from the pill buttons (everyone/students/teachers).
        $filter = $request->query('audience');

        $announcements = Announcement::with('author', 'schoolClass')
            ->when(in_array($filter, ['everyone', 'students', 'teachers', 'class']), fn ($q) => $q->where('audience', $filter))
            ->latest()
            ->get();

        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.announcements', compact('announcements', 'classes', 'filter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'body'     => ['required', 'string'],
            'audience' => ['required', 'in:everyone,students,teachers,class'],
            'class_id' => ['nullable', 'required_if:audience,class', 'exists:classes,id'],
            'priority' => ['required', 'in:normal,medium,high'],
        ]);

        $validated['author_id'] = auth()->id();
        // Only keep class_id when the audience is a specific class.
        if ($validated['audience'] !== 'class') {
            $validated['class_id'] = null;
        }

        $announcement = Announcement::create($validated);

        $this->notifyAudience($announcement);

        return redirect()->route('admin.announcements.index')
            ->with('status', 'Announcement posted.');
    }

    private function notifyAudience(Announcement $announcement): void
    {
        $recipients = match ($announcement->audience) {
            'everyone' => User::query(),
            'students' => User::where('role', 'student'),
            'teachers' => User::where('role', 'teacher'),
            'class'    => User::where('role', 'student')
                ->whereHas('student', fn ($q) => $q->where('class_id', $announcement->class_id)),
        };

        Notification::send($recipients->get(), new NewAnnouncementNotification($announcement));
    }
}
