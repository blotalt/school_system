<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Teacher profile is view-only: account edits are admin-controlled,
    // done from the admin Teachers page — no update() action here.
    public function edit(Request $request)
    {
        $teacher = $request->user()->teacher()->with(['subjects', 'classes'])->first();

        return view('teacher.profile', ['user' => $request->user(), 'teacher' => $teacher]);
    }
}
