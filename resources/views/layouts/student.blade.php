<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Student</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}?v={{ filemtime(public_path('css/style1.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/st-style.css') }}?v={{ filemtime(public_path('css/st-style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/ad-style.css') }}?v={{ filemtime(public_path('css/ad-style.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <x-sidebar>
        <div>
            <div class="logo">
                <h2>Cambodia High School</h2>
                <p>{{ __('nav.academic_year') }}</p>
            </div>
            <ul class="menu">
                <li><a href="/student/dashboard" class="{{ request()->is('student/dashboard') || request()->is('student') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> {{ __('common.dashboard') }}</a></li>
                <li><a href="/student/grades" class="{{ request()->is('student/grades*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i> {{ __('nav.grades_nav') }}</a></li>
                <li><a href="/student/homework" class="{{ request()->is('student/homework*') ? 'active' : '' }}"><i class="fa-solid fa-book"></i> {{ __('nav.homework_nav') }}</a></li>
                <li><a href="/student/schedule" class="{{ request()->is('student/schedule*') ? 'active' : '' }}"><i class="fa-regular fa-calendar"></i> {{ __('nav.schedule_nav') }}</a></li>
                <li><a href="/student/attendance" class="{{ request()->is('student/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> {{ __('nav.attendance_nav') }}</a></li>
                <li><a href="/student/announcements" class="{{ request()->is('student/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> {{ __('nav.announcements_nav') }}</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="{{ route('student.profile.edit') }}"><i class="fa-solid fa-gear"></i> {{ __('nav.settings') }}</a>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>
            <x-live-search :endpoint="route('student.search')" placeholder="{{ __('nav.search_placeholder_student') }}" />
            <div class="top-right">
                <x-notifications-bell />
                <div class="icon-btn"><i class="fa-solid fa-grip"></i></div>
                <div class="teacher profile-dropdown-wrapper" onclick="toggleProfileDropdown(event)">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->displayName() }}</h4>
                        <span>{{ __('common.student') }}</span>
                    </div>
                    <img src="{{ auth()->user()->profilePicture() }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;cursor:pointer;">

                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-user-info">
                            <img src="{{ auth()->user()->profilePicture() }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                            <div>
                                <strong>{{ auth()->user()->displayName() }}</strong>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('student.profile.edit') }}"><i class="fa-solid fa-gear"></i> {{ __('nav.settings') }}</a>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> {{ __('nav.log_out') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </x-page-header>

        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script>
const PASSWORD_LABELS = {
    show: @json(__('common.show_password')),
    hide: @json(__('common.hide_password')),
};

function togglePasswordVisibility(btn) {
    const input = btn.previousElementSibling;
    const icon = btn.querySelector('i');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
    btn.setAttribute('aria-label', isHidden ? PASSWORD_LABELS.hide : PASSWORD_LABELS.show);
}

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
