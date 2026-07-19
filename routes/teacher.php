<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\ProfileController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\AttendanceController;
// use App\Http\Controllers\Teacher\HomeworkController;
// use App\Http\Controllers\Teacher\ExamController;
// use App\Http\Controllers\Teacher\GradebookController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'index']); // alias: sidebar links to /teacher/dashboard
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('classes/{class}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
Route::post('classes/{class}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

// Sidebar links to a bare /teacher/attendance; route it to the teacher's
// first class since attendance is always taken per-class.
Route::get('attendance', function () {
    $class = auth()->user()->teacher?->classes()->first();

    return $class
        ? redirect()->route('teacher.attendance.show', $class)
        : redirect()->route('teacher.classes.index');
})->name('attendance.index');

Route::get('gradebook', fn () => view('teacher.gradebook'))->name('gradebook');
Route::get('announcements', fn () => view('teacher.announcements'))->name('announcements');
Route::get('myprofile', fn () => view('teacher.myprofile'))->name('myprofile');

// Not yet built out (empty placeholder views):
// Route::resource('homework', HomeworkController::class);
// Route::resource('exams', ExamController::class);
// Route::get('gradebook/{exam}', [GradebookController::class, 'show'])->name('gradebook.show');
// Route::post('gradebook/{exam}', [GradebookController::class, 'store'])->name('gradebook.store');
