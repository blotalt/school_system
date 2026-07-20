<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\HomeworkController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\AnnouncementsController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('classes', [ClassController::class, 'index'])->name('classes.index');

Route::resource('homework', HomeworkController::class);

Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
Route::post('exams', [ExamController::class, 'store'])->name('exams.store');
Route::put('exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
Route::delete('exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');

Route::get('gradebook/{exam}', [GradebookController::class, 'show'])->name('gradebook.show');
Route::post('gradebook/{exam}', [GradebookController::class, 'store'])->name('gradebook.store');

Route::get('attendance/{class}', [AttendanceController::class, 'show'])->name('attendance.show');
Route::post('attendance/{class}', [AttendanceController::class, 'store'])->name('attendance.store');

Route::get('announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');
