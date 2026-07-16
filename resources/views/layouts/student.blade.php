


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/st-style.css') }}">
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
                <li><a href="/student/dashboard" class="{{ request()->is('student/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> My Schedule</a></li>
                <li><a href="/student/grades" class="{{ request()->is('student/grades*') ? 'active' : '' }}"><i class="fa-solid fa-user-graduate"></i> Grade / Report Card</a></li>
                <li><a href="/student/attendance" class="{{ request()->is('student/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> Attendance</a></li>
                <li><a href="/student/announcements" class="{{ request()->is('student/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="/settings"><i class="fa-solid fa-gear"></i> Settings</a>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>
    <div class="search-box">
        <input type="text" placeholder="Search"><i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <div class="top-right"><div class="icon-btn"><i class="fa-regular fa-bell"></i>
        </div>

        <div class="icon-btn">
            <i class="fa-solid fa-grip"></i>
        </div>

        <div class="teacher">

            <div class="teacher-info">
                <h4>Bruno Mars</h4>
                <span>Student</span>
            </div>

            <a href="/st-myprofile">
                <img src="{{ asset('images/avatar.png') }}"
                     class="avatar"
                     alt="Student">
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
