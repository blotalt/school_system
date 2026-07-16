<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with(['teacher.user', 'students'])->paginate(20);

        return view('admin.classes', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();

        return view('admin.classes-create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'track'       => ['nullable', 'string', 'max:255'],
            'grade_level' => ['nullable', 'string', 'max:255'],
            'teacher_id'  => ['nullable', 'exists:teachers,id'],
        ]);

        SchoolClass::create($request->only('name', 'track', 'grade_level', 'teacher_id'));

        return redirect()->route('admin.classes.index')->with('success', 'Class created.');
    }

    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::with('user')->get();

        return view('admin.classes-edit', compact('class', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'track'       => ['nullable', 'string', 'max:255'],
            'grade_level' => ['nullable', 'string', 'max:255'],
            'teacher_id'  => ['nullable', 'exists:teachers,id'],
        ]);

        $class->update($request->only('name', 'track', 'grade_level', 'teacher_id'));

        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Class deleted.');
    }
}
