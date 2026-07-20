<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Admin</title>
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
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.students.index') }}" class="{{ request()->is('admin/students*') ? 'active' : '' }}"><i class="fa-solid fa-user-graduate"></i> Students</a></li>
                <li><a href="{{ route('admin.teachers.index') }}" class="{{ request()->is('admin/teachers*') ? 'active' : '' }}"><i class="fa-solid fa-chalkboard-user"></i> Teachers</a></li>
                <li><a href="{{ route('admin.classes.index') }}" class="{{ request()->is('admin/classes*') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> Classes</a></li>
                <li><a href="{{ route('admin.attendance.index') }}" class="{{ request()->is('admin/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> Attendance</a></li>
                <li><a href="{{ route('admin.exams.index') }}" class="{{ request()->is('admin/exams*') ? 'active' : '' }}"><i class="fa-regular fa-clipboard"></i> Exams</a></li>
                <li><a href="{{ route('admin.announcements.index') }}" class="{{ request()->is('admin/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
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
                <div class="icon-btn"><i class="fa-solid fa-grip"></i></div>
                <div class="teacher profile-dropdown-wrapper" onclick="toggleProfileDropdown(event)">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Administrator</span>
                    </div>
                    <div class="avatar-circle">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-user-info">
                            <div class="avatar-circle" style="width:44px;height:44px;">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                            <div>
                                <strong>{{ auth()->user()->name }}</strong>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </x-page-header>

        @yield('content')
    </main>
</div>
<script>
function toggleProfileDropdown(e) {
    e.stopPropagation();
    document.getElementById('profileDropdown').classList.toggle('show');
}
document.addEventListener('click', function() {
    document.getElementById('profileDropdown')?.classList.remove('show');
});
</script>
</body>
</html>
