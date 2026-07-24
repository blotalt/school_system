<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}?v={{ filemtime(public_path('css/style1.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/te-style2.css') }}?v={{ filemtime(public_path('css/te-style2.css')) }}">
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
                <li><a href="/teacher/dashboard" class="{{ request()->is('teacher/dashboard') || request()->is('teacher') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> {{ __('common.dashboard') }}</a></li>
                <li><a href="/teacher/schedule" class="{{ request()->is('teacher/schedule*') ? 'active' : '' }}"><i class="fa-regular fa-calendar"></i> {{ __('nav.schedule_nav') }}</a></li>
                <li><a href="/teacher/classes" class="{{ request()->is('teacher/classes*') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> {{ __('nav.classes_nav') }}</a></li>
                <li><a href="/teacher/attendance" class="{{ request()->is('teacher/attendance*') ? 'active' : '' }}"><i class="fa-solid fa-user-check"></i> {{ __('nav.attendance_nav') }}</a></li>
                <li><a href="/teacher/homework" class="{{ request()->is('teacher/homework*') ? 'active' : '' }}"><i class="fa-solid fa-book"></i> {{ __('nav.homework_nav') }}</a></li>
                <li><a href="/teacher/exams" class="{{ request()->is('teacher/exams*') ? 'active' : '' }}"><i class="fa-solid fa-file-lines"></i> {{ __('nav.exams_nav') }}</a></li>
                <li><a href="/teacher/gradebook" class="{{ request()->is('teacher/gradebook*') ? 'active' : '' }}"><i class="fa-regular fa-clipboard"></i> {{ __('nav.gradebook_nav') }}</a></li>
                <li><a href="/teacher/announcements" class="{{ request()->is('teacher/announcements*') ? 'active' : '' }}"><i class="fa-solid fa-bullhorn"></i> {{ __('nav.announcements_nav') }}</a></li>
            </ul>
        </div>
        <div class="settings">
            <a href="{{ route('teacher.profile.edit') }}"><i class="fa-solid fa-gear"></i> {{ __('nav.settings') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fa-solid fa-right-from-bracket"></i> {{ __('nav.log_out_alt') }}</a>
            </form>
        </div>
    </x-sidebar>

    <main class="main">
        <x-page-header>
            <x-live-search :endpoint="route('teacher.search')" placeholder="{{ __('nav.search_placeholder_teacher') }}" />
            <div class="top-right">
                <x-notifications-bell />
                <div class="teacher">
                    <div class="teacher-info">
                        <h4>{{ auth()->user()->displayName() }}</h4>
<span>{{ __('common.teacher') }}</span>
</div>
<a href="{{ route('teacher.profile.edit') }}">
    <img src="{{ auth()->user()->profilePicture() }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
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
