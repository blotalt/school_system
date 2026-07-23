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
            <a href="{{ route('admin.profile.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>
            <div class="search-box-wrapper" onclick="event.stopPropagation()">
                <div class="search-box">
                    <input type="text" id="globalSearchInput" placeholder="Search students, teachers, classes, exams..." autocomplete="off">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="search-results" id="globalSearchResults"></div>
            </div>
            <div class="top-right">
                <x-notifications-bell />
                <div class="icon-btn"><i class="fa-solid fa-grip"></i></div>
                @php $initials = collect(explode(' ', auth()->user()->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode(''); @endphp
                <div class="teacher profile-dropdown-wrapper" onclick="toggleProfileDropdown(event)">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <span>Administrator</span>
                    </div>
                    <div class="avatar-circle">{{ $initials }}</div>

                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-user-info">
                            <div class="avatar-circle" style="width:44px;height:44px;">{{ $initials }}</div>
                            <div>
                                <strong>{{ auth()->user()->name }}</strong>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('admin.profile.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a>
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

(function() {
    const input = document.getElementById('globalSearchInput');
    const panel = document.getElementById('globalSearchResults');
    let debounceTimer = null;
    let currentRequest = null;

    function renderResults(groups) {
        const keys = Object.keys(groups || {});
        if (keys.length === 0) {
            panel.innerHTML = '<div class="search-empty">No results found</div>';
            panel.classList.add('show');
            return;
        }

        panel.innerHTML = keys.map(function(group) {
            const items = groups[group].map(function(item) {
                return '<a href="' + item.url + '" class="search-result-item">'
                    + '<span class="search-result-title">' + item.title + '</span>'
                    + '<span class="search-result-subtitle">' + (item.subtitle || '') + '</span>'
                    + '</a>';
            }).join('');
            return '<div class="search-group"><div class="search-group-label">' + group + '</div>' + items + '</div>';
        }).join('');
        panel.classList.add('show');
    }

    input.addEventListener('input', function() {
        const q = input.value.trim();
        clearTimeout(debounceTimer);

        if (q.length < 2) {
            panel.classList.remove('show');
            panel.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(function() {
            if (currentRequest) currentRequest.abort();
            const controller = new AbortController();
            currentRequest = controller;

            fetch('{{ route('admin.search') }}?q=' + encodeURIComponent(q), { signal: controller.signal })
                .then(function(res) { return res.json(); })
                .then(function(data) { renderResults(data.results); })
                .catch(function(err) { if (err.name !== 'AbortError') console.error(err); });
        }, 250);
    });

    input.addEventListener('focus', function() {
        if (panel.innerHTML.trim() !== '') panel.classList.add('show');
    });

    document.addEventListener('click', function() {
        panel.classList.remove('show');
    });
})();
</script>
</body>
</html>