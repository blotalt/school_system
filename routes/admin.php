<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
// use App\Http\Controllers\Admin\ExamController;       // B3
use App\Http\Controllers\Admin\AttendanceController; // B4
use App\Http\Controllers\Admin\AnnouncementController; // B4



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

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route::resource('students', StudentController::class);
// Route::resource('teachers', TeacherController::class);
// Route::resource('classes', ClassController::class);

// // Route::resource('exams', ExamController::class);
// // Route::resource('announcements', AnnouncementController::class);
// // Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
// Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
// Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');