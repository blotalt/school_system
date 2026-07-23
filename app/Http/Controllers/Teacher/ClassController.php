<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        $classes = $teacher
            ? $teacher->assignedClasses()->withCount('students')->get()
            : collect();

        return view('teacher.classes', compact('classes'));
    }
}