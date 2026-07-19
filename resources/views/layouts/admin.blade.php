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
                <li><a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="/admin/students" class="{{ request()->is('admin/students*') ? 'active' : '' }}"><i class="fa-solid fa-user-graduate"></i> Students</a></li>
                <li><a href="/admin/teachers" class="{{ request()->is('admin/teachers*') ? 'active' : '' }}"><i class="fa-solid fa-chalkboard-user"></i> Teachers</a></li>
                <li><a href="/admin/classes" class="{{ request()->is('admin/classes*') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> Classes</a></li>
                <li><a href="/admin/attendance" class="{{ request()->is('admin/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> Attendance</a></li>
                <li><a href="/admin/exams" class="{{ request()->is('admin/exams*') ? 'active' : '' }}"><i class="fa-regular fa-clipboard"></i> Exams</a></li>
                <li><a href="/admin/announcements" class="{{ request()->is('admin/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> Announcements</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="/settings"><i class="fa-solid fa-gear"></i> Settings</a>
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
                <div class="icon-btn"><i class="fa-solid fa-grip"></i></div>
                <div class="teacher profile-dropdown-wrapper" onclick="toggleProfileDropdown(event)">
                    <div class="teacher-info">
                        <h4>Chann Socheat</h4>
                        <span>Senior Administrator</span>
                    </div>
                    <div class="avatar-circle">CS</div>

                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-user-info">
                            <div class="avatar-circle" style="width:44px;height:44px;">CS</div>
                            <div>
                                <strong>Chann Socheat</strong>
                                <p>chann.socheat@cambodiahigh.edu.kh</p>
                            </div>
                        </div>
                        <hr>
                        <a href="#"><i class="fa-solid fa-gear"></i> Settings</a>
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