<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
// use App\Http\Controllers\Admin\ExamController;       // B3
// use App\Http\Controllers\Admin\AttendanceController; // B4
// use App\Http\Controllers\Admin\AnnouncementController; // B4

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('classes', ClassController::class);

// Route::resource('exams', ExamController::class);
// Route::resource('announcements', AnnouncementController::class);
// Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
