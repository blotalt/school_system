<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Student</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ad-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <x-sidebar>
        <div>
            <div class="logo">
                <h2>Cambodia High School</h2>
                <p>Academic Year 2025-2026</p>
            </div>
            <ul class="menu">
                <li><a href="{{ route('student.dashboard') }}" class="{{ request()->is('student') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="/student/grades" class="{{ request()->is('student/grades*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i> Grades</a></li>
                <li><a href="/student/homework" class="{{ request()->is('student/homework*') ? 'active' : '' }}"><i class="fa-solid fa-book"></i> Homework</a></li>
                <li><a href="/student/schedule" class="{{ request()->is('student/schedule*') ? 'active' : '' }}"><i class="fa-regular fa-calendar"></i> Schedule</a></li>
                <li><a href="/student/attendance" class="{{ request()->is('student/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> Attendance</a></li>
            </ul>
        </div>
        <div class="settings" style="position:sticky;bottom:0;background:#0b3f86;padding:16px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
            </form>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>

            <div class="top-right">
                <div class="icon-btn"><i class="fa-regular fa-bell"></i></div>
                <div class="teacher">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Student</span>
                    </div>
                    <div class="avatar-circle" style="width:40px;height:40px;">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                </div>
            </div>
        </x-page-header>

        @yield('content')
    </main>
</div>
</body>
</html>