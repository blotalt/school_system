<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AnnouncementController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('classes', ClassController::class);

Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
Route::get('exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
Route::delete('exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');

Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');

Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
Route::put('announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');