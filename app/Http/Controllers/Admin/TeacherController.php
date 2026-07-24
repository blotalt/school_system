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
    public function index(Request $request)
    {
        $search = $request->query('search');

        $teachers = Teacher::with(['user', 'subjects', 'classes'])
            ->when($search, fn ($query) => $query->whereHas(
                'user',
                fn ($user) => $user->where('name', 'like', "%{$search}%")
            ))
            ->paginate(20)
            ->withQueryString();

        return view('admin.teachers', compact('teachers', 'search'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->get();

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

        // NOTE: User model casts password as 'hashed' automatically — no Hash::make() needed
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

            SchoolClass::whereIn('id', $request->input('classes', []))
                ->update(['teacher_id' => $teacher->id]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher account created.');
    }

    public function edit(Teacher $teacher)
    {
        $subjects = Subject::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->get();
        $assignedSubjectIds = $teacher->subjects()->pluck('subjects.id')->all();
        $assignedClassIds = $teacher->classes()->pluck('id')->all();

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
            ], fn ($value) => $value !== null));

            $teacher->update([
                'date_of_birth' => $request->date_of_birth,
                'gender'        => $request->gender,
                'phone'         => $request->phone,
            ]);

            $teacher->subjects()->sync($request->input('subjects', []));

            // Release classes this teacher no longer teaches, then assign the newly selected ones.
            SchoolClass::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);
            SchoolClass::whereIn('id', $request->input('classes', []))
                ->update(['teacher_id' => $teacher->id]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            $user = $teacher->user;
            SchoolClass::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);
            $teacher->delete();
            $user->delete();
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted.');
    }
}
