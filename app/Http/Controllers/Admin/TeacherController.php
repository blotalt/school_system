<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'subjects', 'assignedClasses'])->paginate(20);

        return view('admin.teachers', compact('teachers'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        $classes  = SchoolClass::orderBy('name')->get();

        return view('admin.teachers-create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8'],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => ['nullable', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:255'],
            'subjects'      => ['nullable', 'array'],
            'subjects.*'    => ['exists:subjects,id'],
            'classes'       => ['nullable', 'array'],
            'classes.*'     => ['exists:classes,id'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
                'role'     => 'teacher',
            ]);

            $teacher = Teacher::create([
                'user_id'       => $user->id,
                'date_of_birth' => $request->date_of_birth,
                'gender'        => $request->gender,
                'phone'         => $request->phone,
            ]);

            $teacher->subjects()->sync($request->input('subjects', []));
            $teacher->assignedClasses()->sync($request->input('classes', []));
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher account created.');
    }

    public function edit(Teacher $teacher)
    {
        $subjects           = Subject::orderBy('name')->get();
        $classes            = SchoolClass::orderBy('name')->get();
        $assignedSubjectIds = $teacher->subjects()->pluck('subjects.id')->all();
        $assignedClassIds   = $teacher->assignedClasses()->pluck('classes.id')->all();

        return view('admin.teachers-edit', compact('teacher', 'subjects', 'classes', 'assignedSubjectIds', 'assignedClassIds'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', "unique:users,email,{$teacher->user_id}"],
            'password'      => ['nullable', 'string', 'min:8'],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => ['nullable', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:255'],
            'subjects'      => ['nullable', 'array'],
            'subjects.*'    => ['exists:subjects,id'],
            'classes'       => ['nullable', 'array'],
            'classes.*'     => ['exists:classes,id'],
        ]);

        DB::transaction(function () use ($request, $teacher) {
            $teacher->user->update(array_filter([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password ?: null,
            ], fn($value) => $value !== null));

            $teacher->update([
                'date_of_birth' => $request->date_of_birth,
                'gender'        => $request->gender,
                'phone'         => $request->phone,
            ]);

            $teacher->subjects()->sync($request->input('subjects', []));
            $teacher->assignedClasses()->sync($request->input('classes', []));
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            $user = $teacher->user;
            $teacher->assignedClasses()->detach();
            $teacher->delete();
            $user->delete();
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted.');
    }
}