<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return 'STUDENT dashboard — logged in as ' . auth()->user()->name;
    }
}