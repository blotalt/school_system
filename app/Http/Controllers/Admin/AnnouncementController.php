<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

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

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
            ->with('status', 'Announcement posted.');
    }
}
