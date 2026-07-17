<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Student\DashboardController;

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

Route::get('/student/grades', function () {
    return view('student.grades');
})->name('student.grades');

Route::get('/student/attendance', function () {
    return view('student.attendance');
})->name('student.attendance');

Route::get('/student/announcements', function () {
    return view('student.announcements');
})->name('student.announcements');

Route::get('/student/myprofile', function () {
    return view('student.myprofile');
})->name('student.myprofile');



// use App\Http\Controllers\Student\GradeController;
// use App\Http\Controllers\Student\HomeworkController;
// use App\Http\Controllers\Student\ScheduleController;
// use App\Http\Controllers\Student\AttendanceController;

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
// Route::get('homework', [HomeworkController::class, 'index'])->name('homework.index');
// Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
// Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
