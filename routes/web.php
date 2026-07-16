<?php

use Illuminate\Support\Facades\Route;







Route::get('/', function () {
    return view('layouts.teacher');
});



//Teacher Routes
Route::get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
});

Route::get('/teacher/classes', function () {
    return view('teacher.classes');
});

Route::get('/teacher/attendance', function () {
    return view('teacher.attendance');
});

Route::get('/teacher/gradebook', function () {
    return view('teacher.gradebook');
});

Route::get('/teacher/announcements', function () {
    return view('teacher.announcements');
});

Route::get('/teacher/myprofile', function () {
    return view('teacher.myprofile');
});


//Student Routes

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
});

Route::get('/student/grades', function () {
    return view('student.grades');
});
Route::get('/student/announcements', function () {
    return view('student.announcements');
});
Route::get('/student/attendance', function () {
    return view('student.attendance');
});
Route::get('/student/myprofile', function () {
    return view('student.myprofile');
});



// DELETE these:
Route::get('register', [RegisteredUserController::class, 'create']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
Route::get('/admin/students', fn() => view('admin.students'))->name('admin.students.index');
Route::get('/admin/students/create', fn() => view('admin.students-create'))->name('admin.students.create');
Route::get('/admin/teachers', fn() => view('admin.teachers'))->name('admin.teachers.index');
Route::get('/admin/teachers/create', fn() => view('admin.teachers-create'))->name('admin.teachers.create');
Route::get('/admin/classes', fn() => view('admin.classes'))->name('admin.classes.index');
Route::get('/admin/attendance', fn() => view('admin.attendance'))->name('admin.attendance.index');
Route::get('/admin/announcements', fn() => view('admin.announcements'))->name('admin.announcements.index');