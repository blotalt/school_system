<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Student\DashboardController;
// use App\Http\Controllers\Student\GradeController;
// use App\Http\Controllers\Student\HomeworkController;
// use App\Http\Controllers\Student\ScheduleController;
// use App\Http\Controllers\Student\AttendanceController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
// Route::get('homework', [HomeworkController::class, 'index'])->name('homework.index');
// Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
// Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');