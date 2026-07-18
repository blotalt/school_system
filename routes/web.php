<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default   => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(base_path('routes/teacher.php'));

Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(base_path('routes/student.php'));

Route::get('/admin/exams', fn() => view('admin.exams'))->name('admin.exams.index');
Route::get('/admin/exams/{id}/results', fn($id) => view('admin.exams-results'))->name('admin.exams.results');