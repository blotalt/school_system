<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\HomeworkController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Teacher\AttendanceController;

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('classes', [ClassController::class, 'index'])->name('classes.index');

// Route::resource('homework', HomeworkController::class);
// Route::resource('exams', ExamController::class);

// Route::get('gradebook/{exam}', [GradebookController::class, 'show'])->name('gradebook.show');
// Route::post('gradebook/{exam}', [GradebookController::class, 'store'])->name('gradebook.store');

Route::get('/teacher/classes/{class}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
Route::post('/teacher/classes/{class}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');


Route::get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->name('teacher.dashboard');

Route::get('/teacher/classes', function () {
    return view('teacher.classes');
})->name('teacher.classes');
Route::get('/teacher/attendance', function () {
    return view('teacher.attendance');
})->name('teacher.attendance');

Route::get('/teacher/gradebook', function () {
    return view('teacher.gradebook');
})->name('teacher.gradebook');



Route::get('/teacher/announcements', function () {
    return view('teacher.announcements');
})->name('teacher.announcements');

Route::get('/teacher/myprofile', function () {
    return view('teacher.myprofile');
})->name('teacher.myprofile');






