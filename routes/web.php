<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\GradebookController;

Route::get('/', function () {

    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect('/teacher/dashboard'),
            'student' => redirect('/student/dashboard'),
            default   => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
});


// =======================
// Teacher Routes
// =======================

Route::get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->name('teacher.dashboard');

Route::get('/teacher/classes', function () {
    return view('teacher.classes');
})->name('teacher.classes');

Route::get('/teacher/classes/{class}/attendance', [AttendanceController::class, 'show'])
    ->name('teacher.attendance.show');

Route::post('/teacher/classes/{class}/attendance', [AttendanceController::class, 'store'])
    ->name('teacher.attendance.store');

Route::get('/teacher/classes/{class}/gradebook/{exam}', [GradebookController::class, 'show'])
    ->name('teacher.gradebook.show');

Route::post('/teacher/classes/{class}/gradebook/{exam}', [GradebookController::class, 'store'])
    ->name('teacher.gradebook.store');

Route::get('/teacher/announcements', function () {
    return view('teacher.announcements');
})->name('teacher.announcements');

Route::get('/teacher/myprofile', function () {
    return view('teacher.myprofile');
})->name('teacher.myprofile');


// =======================
// Student Routes
// =======================

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

Route::get('/student/grades', function () {
    return view('student.grades');
})->name('student.grades');

Route::get('/student/attendance', function () {
    return view('student.attendance');
})->name('student.attendance');

Route::get('/student/announcements', function () {
    return view('student.announcements');
})->name('student.announcements');

Route::get('/student/myprofile', function () {
    return view('student.myprofile');
})->name('student.myprofile');


// =======================
// Admin Routes
// =======================

Route::get('/admin/dashboard', fn () => view('admin.dashboard'))
    ->name('admin.dashboard');

Route::get('/admin/students', fn () => view('admin.students'))
    ->name('admin.students.index');

Route::get('/admin/students/create', fn () => view('admin.students-create'))
    ->name('admin.students.create');

Route::get('/admin/teachers', fn () => view('admin.teachers'))
    ->name('admin.teachers.index');

Route::get('/admin/teachers/create', fn () => view('admin.teachers-create'))
    ->name('admin.teachers.create');

Route::get('/admin/classes', fn () => view('admin.classes'))
    ->name('admin.classes.index');

Route::get('/admin/attendance', fn () => view('admin.attendance'))
    ->name('admin.attendance.index');

Route::get('/admin/announcements', fn () => view('admin.announcements'))
    ->name('admin.announcements.index');


// Laravel Breeze/Auth routes
require __DIR__.'/auth.php';