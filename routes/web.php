<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// DELETE these:
Route::get('register', [RegisteredUserController::class, 'create']);
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
Route::get('/admin/students', fn() => view('admin.students'))->name('admin.students.index');
Route::get('/admin/students/create', fn() => view('admin.students-create'))->name('admin.students.create');
Route::get('/admin/teachers', fn() => view('admin.teachers'))->name('admin.teachers.index');
Route::get('/admin/teachers/create', fn() => view('admin.teachers-create'))->name('admin.teachers.create');
Route::get('/admin/classes', fn() => view('admin.classes'))->name('admin.classes.index');
Route::get('/admin/attendance', fn() => view('admin.attendance'))->name('admin.attendance.index');
Route::get('/admin/announcements', fn() => view('admin.announcements'))->name('admin.announcements.index');