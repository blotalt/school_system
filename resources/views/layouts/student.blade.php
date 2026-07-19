<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Student</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/st-style.css') }}">
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
                <li><a href="/student/dashboard" class="{{ request()->is('student/dashboard') || request()->is('student') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="/student/grades" class="{{ request()->is('student/grades*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i> Grades</a></li>
                <li><a href="/student/homework" class="{{ request()->is('student/homework*') ? 'active' : '' }}"><i class="fa-solid fa-book"></i> Homework</a></li>
                <li><a href="/student/schedule" class="{{ request()->is('student/schedule*') ? 'active' : '' }}"><i class="fa-regular fa-calendar"></i> Schedule</a></li>
                <li><a href="/student/attendance" class="{{ request()->is('student/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> Attendance</a></li>
                <li><a href="/student/announcements" class="{{ request()->is('student/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="{{ route('student.profile.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
            </form>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>
            <div class="search-box">
                <input type="text" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="top-right">
                <x-notifications-bell />
                <div class="teacher">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Student</span>
                    </div>
                    <a href="{{ route('student.profile.edit') }}">
                        <div class="avatar-circle" style="width:40px;height:40px;">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    </a>
                </div>
            </div>
        </x-page-header>

        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
