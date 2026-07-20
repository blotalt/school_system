<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;

class ClassController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        $classes = $teacher
            ? SchoolClass::where('teacher_id', $teacher->id)
                ->withCount('students')
                ->get()
            : collect();

        return view('teacher.classes', compact('classes', 'teacher'));
    }
}
