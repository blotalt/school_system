<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\ProfileController;
// use App\Http\Controllers\Teacher\ClassController;
// use App\Http\Controllers\Teacher\HomeworkController;
// use App\Http\Controllers\Teacher\ExamController;
// use App\Http\Controllers\Teacher\GradebookController;
// use App\Http\Controllers\Teacher\AttendanceController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

// Route::get('classes', [ClassController::class, 'index'])->name('classes.index');

// Route::resource('homework', HomeworkController::class);
// Route::resource('exams', ExamController::class);

// Route::get('gradebook/{exam}', [GradebookController::class, 'show'])->name('gradebook.show');
// Route::post('gradebook/{exam}', [GradebookController::class, 'store'])->name('gradebook.store');

// Route::get('attendance/{class}', [AttendanceController::class, 'show'])->name('attendance.show');
// Route::post('attendance/{class}', [AttendanceController::class, 'store'])->name('attendance.store');