<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return 'TEACHER dashboard — logged in as ' . auth()->user()->name;
    }
}