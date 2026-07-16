<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(20);

        return view('admin.teachers', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'unique:users,email'],
            'password'          => ['required', 'string', 'min:8'],
            'subject_specialty' => ['nullable', 'string', 'max:255'],
        ]);

        // NOTE: User model casts password as 'hashed' automatically — no Hash::make() needed
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
                'role'     => 'teacher',
            ]);

            Teacher::create([
                'user_id'           => $user->id,
                'subject_specialty' => $request->subject_specialty,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher account created.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers-edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', "unique:users,email,{$teacher->user_id}"],
            'subject_specialty' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($request, $teacher) {
            $teacher->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $teacher->update([
                'subject_specialty' => $request->subject_specialty,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            $user = $teacher->user;
            $teacher->delete();
            $user->delete();
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted.');
    }
}
