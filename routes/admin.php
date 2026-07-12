<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\StudentController;
// use App\Http\Controllers\Admin\TeacherController;
// use App\Http\Controllers\Admin\ClassController;
// use App\Http\Controllers\Admin\ExamController;
// use App\Http\Controllers\Admin\AttendanceController;
// use App\Http\Controllers\Admin\AnnouncementController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route::resource('students', StudentController::class);
// Route::resource('teachers', TeacherController::class);
// Route::resource('classes', ClassController::class);
// Route::resource('exams', ExamController::class);
// Route::resource('announcements', AnnouncementController::class);

// Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');