<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/te-style2.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="wrapper">

    <!-- ================= Sidebar ================= -->

   <x-sidebar>

    <div>

        <div class="logo">
            <h2>Cambodia High School</h2>
            <p>Academic Year 2025–2026</p>
        </div>

        <ul class="menu">

            <li>
                <a href="/myschedule" class="{{ request()->is('myschedule') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar"></i>
                    My Schedule
                </a>
            </li>

            <li>
                <a href="/myclass" class="{{ request()->is('myclass') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    My Classes
                </a>
            </li>

            <li>
                <a href="/attendance" class="{{ request()->is('attendance') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-check"></i>
                    Attendance
                </a>
            </li>

            <li>
                <a href="/gradebook" class="{{ request()->is('gradebook') ? 'active' : '' }}">
                    <i class="fa-regular fa-clipboard"></i>
                    Gradebook
                </a>
            </li>

            <li>
                <a href="/announcement" class="{{ request()->is('announcement') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i>
                    Announcements
                </a>
            </li>

        </ul>

    </div>

    <div class="settings">

        <a href="/settings">
            <i class="fa-solid fa-gear"></i>
            Settings
        </a>

    </div>

</x-sidebar>

    <!-- ================= Main ================= -->

    <main class="main">

        <!-- ================= Header ================= -->

        <x-page-header>

    <div class="search-box">

        <input
            type="text"
            placeholder="Search">

        <i class="fa-solid fa-magnifying-glass"></i>

    </div>

    <div class="top-right">

        <div class="icon-btn">
            <i class="fa-regular fa-bell"></i>
        </div>

        <div class="icon-btn">
            <i class="fa-solid fa-grip"></i>
        </div>

        <div class="teacher">

            <div class="teacher-info">

                <h4>Phearun Khun</h4>

                <span>Biology Teacher</span>

            </div>

            <a href="/myprofile">

                <img
                    src="{{ asset('images/avatar.png') }}"
                    class="avatar"
                    alt="Teacher">

            </a>

        </div>

    </div>

</x-page-header>

        <!-- ================= PAGE CONTENT ================= -->

        @yield('content')

    </main>

</div>

{{-- JS --}}
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>

