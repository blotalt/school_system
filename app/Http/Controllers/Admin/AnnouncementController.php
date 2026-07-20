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
        if ($validated['audience'] !== 'class') {
            $validated['class_id'] = null;
        }

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement posted.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'body'     => ['required', 'string'],
            'audience' => ['required', 'in:everyone,students,teachers,class'],
            'class_id' => ['nullable', 'required_if:audience,class', 'exists:classes,id'],
            'priority' => ['required', 'in:normal,medium,high'],
        ]);

        if ($validated['audience'] !== 'class') {
            $validated['class_id'] = null;
        }

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement deleted.');
    }
}