<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Student portal is read-only: no update() action exists, matching the
    // rest of routes/student.php (GET routes only — no POST/PUT/DELETE).
    public function edit(Request $request)
    {
        $student = $request->user()->student()->with('schoolClass')->first();

        return view('student.profile', ['user' => $request->user(), 'student' => $student]);
    }
}
