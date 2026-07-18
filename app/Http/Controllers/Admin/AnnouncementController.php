<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $audience = $request->query('audience');

        $announcements = Announcement::with('author')
            ->when($audience && $audience !== 'all', fn ($query) => $query->where('audience', $audience))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.announcements', compact('announcements', 'audience'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'body'     => ['required', 'string'],
            'audience' => ['required', 'in:all,students,teachers'],
        ]);

        Announcement::create([
            'author_id' => $request->user()->id,
            'title'     => $request->title,
            'body'      => $request->body,
            'audience'  => $request->audience,
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement posted.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}
