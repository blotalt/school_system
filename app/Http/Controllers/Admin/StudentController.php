<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'schoolClass'])->paginate(20);

        return view('admin.students', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.students-create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'string', 'min:8'],
            'class_id'         => ['required', 'exists:classes,id'],
            'roll_no'          => ['required', 'string', 'unique:students,roll_no'],
            'guardian_contact' => ['nullable', 'string', 'max:255'],
            'date_of_birth'    => ['nullable', 'date'],
        ]);

        // NOTE: User model casts password as 'hashed' automatically — no Hash::make() needed
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
                'role'     => 'student',
            ]);

            Student::create([
                'user_id'          => $user->id,
                'class_id'         => $request->class_id,
                'roll_no'          => $request->roll_no,
                'guardian_contact' => $request->guardian_contact,
                'date_of_birth'    => $request->date_of_birth,
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student account created.');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.students-edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', "unique:users,email,{$student->user_id}"],
            'class_id'         => ['required', 'exists:classes,id'],
            'roll_no'          => ['required', 'string', "unique:students,roll_no,{$student->id}"],
            'guardian_contact' => ['nullable', 'string', 'max:255'],
            'date_of_birth'    => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($request, $student) {
            $student->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $student->update([
                'class_id'         => $request->class_id,
                'roll_no'          => $request->roll_no,
                'guardian_contact' => $request->guardian_contact,
                'date_of_birth'    => $request->date_of_birth,
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            $user->delete();
        });

        return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
    }
}
