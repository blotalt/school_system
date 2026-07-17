<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\GradebookController;
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/teacher.php';
require __DIR__.'/student.php';

Route::get('/', function () {

    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect('/teacher/dashboard'),
            'student' => redirect('/student/dashboard'),
            default   => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
});



