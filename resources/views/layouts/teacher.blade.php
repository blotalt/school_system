<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/te-style2.css') }}">
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
                <li><a href="/teacher/dashboard" class="{{ request()->is('teacher/dashboard') || request()->is('teacher') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="/teacher/classes" class="{{ request()->is('teacher/classes*') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> Classes</a></li>
                <li><a href="/teacher/attendance" class="{{ request()->is('teacher/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> Attendance</a></li>
                <li><a href="/teacher/homework" class="{{ request()->is('teacher/homework*') ? 'active' : '' }}"><i class="fa-solid fa-book"></i> Homework</a></li>
                <li><a href="/teacher/exams" class="{{ request()->is('teacher/exams*') ? 'active' : '' }}"><i class="fa-solid fa-file-lines"></i> Exams</a></li>
                <li><a href="/teacher/gradebook" class="{{ request()->is('teacher/gradebook*') ? 'active' : '' }}"><i class="fa-regular fa-clipboard"></i> Gradebook</a></li>
                <li><a href="/teacher/announcements" class="{{ request()->is('teacher/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="{{ route('teacher.profile.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a>
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
                <div class="icon-btn"><i class="fa-regular fa-bell"></i></div>
                <div class="teacher">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Teacher</span>
                    </div>
                    <a href="{{ route('teacher.profile.edit') }}">
                        <div class="avatar-circle" style="width:40px;height:40px;">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    </a>
                </div>
            </div>
        </x-page-header>

        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>
