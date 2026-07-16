<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Teacher\HomeworkController;
use App\Http\Controllers\Teacher\ExamController;







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
// Route::get('register', [RegisteredUserController::class, 'create']);
// Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
Route::get('/admin/students', fn() => view('admin.students'))->name('admin.students.index');
Route::get('/admin/students/create', fn() => view('admin.students-create'))->name('admin.students.create');
Route::get('/admin/teachers', fn() => view('admin.teachers'))->name('admin.teachers.index');
Route::get('/admin/teachers/create', fn() => view('admin.teachers-create'))->name('admin.teachers.create');
Route::get('/admin/classes', fn() => view('admin.classes'))->name('admin.classes.index');
Route::get('/admin/attendance', fn() => view('admin.attendance'))->name('admin.attendance.index');
Route::get('/admin/announcements', fn() => view('admin.announcements'))->name('admin.announcements.index');
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default   => redirect()->route('login'),
        };
    }
    return redirect()->route('login');


require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(base_path('routes/teacher.php'));

Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(base_path('routes/student.php'));
