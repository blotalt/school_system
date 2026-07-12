<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // return 'ADMIN dashboard — logged in as ' . auth()->user()->name;
        return '<h2>ADMIN dashboard — logged in as ' . auth()->user()->name . '</h2>
            <form method="POST" action="/logout">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button type="submit">Log out</button>
            </form>';
    }
}