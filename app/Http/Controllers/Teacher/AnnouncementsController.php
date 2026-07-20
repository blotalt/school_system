<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::visibleToTeacher()
            ->with('author')
            ->latest()
            ->get();

        return view('teacher.announcements', compact('announcements'));
    }
}
