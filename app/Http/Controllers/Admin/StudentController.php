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
    public function index(Request $request)
    {
        $search = $request->query('search');
        $grade  = $request->query('grade');
        $track  = $request->query('track');

        $students = Student::with(['user', 'schoolClass'])
            ->when($search, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")->orWhere('khmer_name', 'like', "%{$search}%")))
            ->when($grade, fn($q) => $q->whereHas('schoolClass', fn($c) => $c->where('grade_level', $grade)))
            ->when($track, fn($q) => $q->whereHas('schoolClass', fn($c) => $c->where('track', $track)))
            ->paginate(20)
            ->withQueryString();

        $students->getCollection()->transform(function (Student $student) {
            $total   = $student->attendances()->count();
            $present = $student->attendances()->where('status', 'present')->count();
            $student->attendance_percent = $total ? (int) round($present / $total * 100) : null;
            return $student;
        });

        $grades = SchoolClass::whereNotNull('grade_level')->distinct()->orderBy('grade_level')->pluck('grade_level');
        $tracks = SchoolClass::whereNotNull('track')->distinct()->orderBy('track')->pluck('track');

        return view('admin.students', compact('students', 'search', 'grade', 'track', 'grades', 'tracks'));
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
            'khmer_name'       => ['nullable', 'string', 'max:255'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'string', 'min:8'],
            'class_id'         => ['required', 'exists:classes,id'],
            'roll_no'          => ['required', 'string', 'unique:students,roll_no'],
            'gender'           => ['nullable', 'in:male,female'],
            'guardian_contact' => ['nullable', 'string', 'max:255'],
            'date_of_birth'    => ['nullable', 'date'],
            'profile_picture'  => ['nullable', 'image', 'max:2048'],
        ]);

        DB::transaction(function () use ($request) {
            $picturePath = null;
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = 'student_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/profiles/uploads'), $filename);
                $picturePath = 'images/profiles/uploads/' . $filename;
            }

            $user = User::create([
                'name'            => $request->name,
                'khmer_name'      => $request->khmer_name,
                'email'           => $request->email,
                'password'        => $request->password,
                'role'            => 'student',
                'profile_picture' => $picturePath,
            ]);

            Student::create([
                'user_id'          => $user->id,
                'class_id'         => $request->class_id,
                'roll_no'          => $request->roll_no,
                'gender'           => $request->gender,
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
            'khmer_name'       => ['nullable', 'string', 'max:255'],
            'email'            => ['required', 'email', "unique:users,email,{$student->user_id}"],
            'password'         => ['nullable', 'string', 'min:8'],
            'class_id'         => ['required', 'exists:classes,id'],
            'roll_no'          => ['required', 'string', "unique:students,roll_no,{$student->id}"],
            'gender'           => ['nullable', 'in:male,female'],
            'guardian_contact' => ['nullable', 'string', 'max:255'],
            'date_of_birth'    => ['nullable', 'date'],
            'profile_picture'  => ['nullable', 'image', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $student) {
            $picturePath = $student->user->profile_picture;
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = 'student_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/profiles/uploads'), $filename);
                $picturePath = 'images/profiles/uploads/' . $filename;
            }

            $student->user->update(array_filter([
                'name'            => $request->name,
                'khmer_name'      => $request->khmer_name,
                'email'           => $request->email,
                'password'        => $request->password ?: null,
                'profile_picture' => $picturePath,
            ], fn($v) => $v !== null));

            $student->update([
                'class_id'         => $request->class_id,
                'roll_no'          => $request->roll_no,
                'gender'           => $request->gender,
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