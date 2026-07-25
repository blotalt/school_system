<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
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
            @php $pendingScheduleRequestsCount = \App\Models\ScheduleRequest::where('status', 'pending')->count(); @endphp
            <ul class="menu">
                <li><a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> {{ __('common.dashboard') }}</a></li>
                <li><a href="/admin/students" class="{{ request()->is('admin/students*') ? 'active' : '' }}"><i class="fa-solid fa-user-graduate"></i> {{ __('nav.students_nav') }}</a></li>
                <li><a href="/admin/teachers" class="{{ request()->is('admin/teachers*') ? 'active' : '' }}"><i class="fa-solid fa-chalkboard-user"></i> {{ __('nav.teachers_nav') }}</a></li>
                <li><a href="/admin/classes" class="{{ request()->is('admin/classes*') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> {{ __('nav.classes_nav') }}</a></li>

                <li><a href="/admin/attendance" class="{{ request()->is('admin/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> {{ __('nav.attendance_nav') }}</a></li>
                <li><a href="/admin/exams" class="{{ request()->is('admin/exams*') ? 'active' : '' }}"><i class="fa-regular fa-clipboard"></i> {{ __('nav.exams_nav') }}</a></li>
                <li><a href="/admin/announcements" class="{{ request()->is('admin/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> {{ __('nav.announcements_nav') }}</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="{{ route('admin.profile.edit') }}"><i class="fa-solid fa-gear"></i> {{ __('nav.settings') }}</a>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>
            <x-live-search :endpoint="route('admin.search')" placeholder="{{ __('nav.search_placeholder_admin') }}" />
            <div class="top-right">
                <x-notifications-bell />
                <div class="icon-btn"><i class="fa-solid fa-grip"></i></div>
                <div class="teacher profile-dropdown-wrapper" onclick="toggleProfileDropdown(event)">
    <div class="teacher-info">
        <h4>{{ auth()->user()->displayName() }}</h4>
        <span>{{ __('admin.administrator') }}</span>
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
                        <a href="{{ route('admin.profile.edit') }}"><i class="fa-solid fa-gear"></i> {{ __('nav.settings') }}</a>
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