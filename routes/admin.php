<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\AttendanceController; // B4
use App\Http\Controllers\Admin\AnnouncementController; // B4
use App\Http\Controllers\Admin\ProfileController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('classes', ClassController::class);
Route::post('classes/{class}/schedule', [ClassController::class, 'storeSchedule'])->name('classes.schedule.store');
Route::delete('classes/{class}/schedule/{schedule}', [ClassController::class, 'destroySchedule'])->name('classes.schedule.destroy');

Route::resource('exams', ExamController::class);
Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results.index');
Route::post('exams/{exam}/results', [ExamController::class, 'storeResults'])->name('exams.results.store');
Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('attendance/{class}', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
// GET method for showing the form
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');

// POST method for processing the form submission
Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
