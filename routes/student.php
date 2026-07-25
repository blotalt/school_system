<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\Student\HomeworkController;
use App\Http\Controllers\Student\ScheduleController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\AnnouncementController;
use App\Http\Controllers\Student\SearchController;

// Student portal is otherwise READ-ONLY: GET routes only. The single
// exception is submitting homework (POST homework/{homework}/submit below) —
// everything else stays view-only, no other POST/PUT/DELETE routes exist.
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'index']); // alias: sidebar links to /student/dashboard
Route::get('search', [SearchController::class, 'search'])->name('search');
Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
Route::get('grades/export', [GradeController::class, 'exportGradesCsv'])->name('grades.export');
Route::get('grades/export/pdf', [GradeController::class, 'exportGradesPdf'])->name('grades.export.pdf');
Route::get('homework', [HomeworkController::class, 'index'])->name('homework.index');
Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('attendance/export', [AttendanceController::class, 'exportAttendanceCsv'])->name('attendance.export');
Route::get('attendance/export/pdf', [AttendanceController::class, 'exportAttendancePdf'])->name('attendance.export.pdf');
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements');

// myprofile duplicated the real profile page before it existed — alias it there.
Route::redirect('myprofile', '/student/profile');

Route::get('view-class/{schedule}', [ScheduleController::class, 'showClass'])->name('view-class');
Route::get('view-task/{homework}', [HomeworkController::class, 'show'])->name('view-task');
Route::post('homework/{homework}/submit', [HomeworkController::class, 'submit'])->name('homework.submit');
