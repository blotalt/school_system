<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\ProfileController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Teacher\AnnouncementController;
use App\Http\Controllers\Teacher\HomeworkController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\ScheduleController;
use App\Http\Controllers\Teacher\SearchController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'index']); // alias: sidebar links to /teacher/dashboard
Route::get('search', [SearchController::class, 'search'])->name('search');
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::post('schedule', [ScheduleController::class, 'store'])->name('schedule.store');
Route::get('classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('classes/{class}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
Route::post('classes/{class}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('classes/{class}/attendance/export', [AttendanceController::class, 'downloadAttendanceCsv'])->name('attendance.export');
Route::get('classes/{class}/attendance/export/pdf', [AttendanceController::class, 'downloadAttendancePdf'])->name('attendance.export.pdf');

// Sidebar links to a bare /teacher/attendance; route it to the teacher's
// first class since attendance is always taken per-class.
Route::get('attendance', function () {
    $class = auth()->user()->teacher?->classes()->first();

    return $class
        ? redirect()->route('teacher.attendance.show', $class)
        : redirect()->route('teacher.classes.index');
})->name('attendance.index');

Route::get('gradebook', [GradebookController::class, 'index'])->name('gradebook.index');
Route::get('gradebook/{exam}', [GradebookController::class, 'show'])->name('gradebook.show');
Route::post('gradebook/{exam}', [GradebookController::class, 'store'])->name('gradebook.store');
Route::get('gradebook/{exam}/export', [GradebookController::class, 'export'])->name('gradebook.export');
Route::get('gradebook/{exam}/export/pdf', [GradebookController::class, 'downloadGradebookPdf'])->name('gradebook.export.pdf');

Route::resource('homework', HomeworkController::class)->except(['show']);
Route::get('homework/{homework}/submissions', [HomeworkController::class, 'submissions'])->name('homework.submissions');
Route::post('homework/{homework}/submissions/grade', [HomeworkController::class, 'grade'])->name('homework.submissions.grade');
Route::resource('exams', ExamController::class)->except(['show']);

Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements');

// myprofile duplicated the real profile page before it existed — alias it there.
Route::redirect('myprofile', '/teacher/profile');
