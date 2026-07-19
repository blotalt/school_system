<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\Student\HomeworkController;
use App\Http\Controllers\Student\ScheduleController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\ProfileController;

// Student portal is READ-ONLY: GET routes only. No POST/PUT/DELETE exist,
// so a student physically cannot submit anything (rule enforced by absence).
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'index']); // alias: sidebar links to /student/dashboard
Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
Route::get('homework', [HomeworkController::class, 'index'])->name('homework.index');
Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('announcements', fn () => view('student.announcements'))->name('announcements');
Route::get('myprofile', fn () => view('student.myprofile'))->name('myprofile');
Route::get('view-class', fn () => view('student.view-class'))->name('view-class');
Route::get('view-task', fn () => view('student.view-task'))->name('view-task');
