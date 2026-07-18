<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;

// Route::get('/', function () {
//     if (auth()->check()) {
//         return match (auth()->user()->role) {
//             'admin'   => redirect()->route('admin.dashboard'),
//             'teacher' => redirect()->route('teacher.dashboard'),
//             'student' => redirect()->route('student.dashboard'),
//             default   => redirect()->route('login'),
//         };
//     }
//     return redirect()->route('login');
// });


Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Central Dashboard Traffic Cop: Protected by 'auth' middleware
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default   => redirect()->route('login'),
        };
    })->name('dashboard'); // <-- This gives the route its name so the redirect above works!

});
// Route::get('/myprofile', function () {
//         return match (auth()->user()->role) {
//             'admin'   => redirect()->route('admin.profile.edit'), // Make sure these route names exist in your subfiles!
//             'teacher' => redirect()->route('teacher.profile.edit'),
//             'student' => redirect()->route('student.profile.edit'),
//             default   => redirect()->route('login'),
//         };
//     })->name('myprofile');

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

