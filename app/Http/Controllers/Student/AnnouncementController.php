<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        $announcements = Announcement::visibleToStudent($student?->class_id)
            ->with('author')
            ->latest()
            ->get();

        return view('student.announcements', compact('announcements'));
    }
}
