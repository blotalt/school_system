@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>{{ __('teacher.dashboard.welcome', ['name' => $teacher?->user->displayName() ?? auth()->user()->displayName()]) }}</h1>
        <p>{{ __('teacher.dashboard.subtitle') }}</p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-school"></i></div>
        <div class="stat-value">{{ $classes->count() }}</div>
        <div class="stat-label">{{ __('teacher.dashboard.stat_my_classes') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
        <div class="stat-value">{{ number_format($studentCount) }}</div>
        <div class="stat-label">{{ __('teacher.dashboard.stat_total_students') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-regular fa-clipboard"></i></div>
        <div class="stat-value">{{ number_format($examCount) }}</div>
        <div class="stat-label">{{ __('teacher.dashboard.stat_exams_created') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-value">{{ $attendanceRate }}%</div>
        <div class="stat-label">{{ __('teacher.dashboard.stat_attendance_rate') }}</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>{{ __('teacher.dashboard.my_classes') }}</h3>
        <a href="/teacher/classes">{{ __('common.view_all') }}</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('teacher.dashboard.class_name') }}</th>
                <th>{{ __('common.track') }}</th>
                <th>{{ __('teacher.dashboard.students') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>{{ $class->displayName() }}</td>
                    <td>{{ $class->displayTrack() ?: __('common.default_track') }}</td>
                    <td>{{ $class->students_count }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;color:#8a94a6;">{{ __('teacher.dashboard.no_classes_assigned') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="today-card">
    <div class="today-header">
        <h2>{{ __('teacher.dashboard.todays_schedule') }}</h2>
    </div>

    @forelse($todaySchedule as $slot)
        <div class="today-item">
            <div class="today-left">
                <span class="time">{{ $slot->time }}</span>
                <h3>{{ $slot->subject }}</h3>
                <p>{{ $slot->class }}</p>
            </div>
        </div>
    @empty
        <div class="today-item"><div class="today-left"><p>{{ __('teacher.dashboard.no_classes_scheduled') }}</p></div></div>
    @endforelse
</div>

<div class="today-card" style="margin-top:20px;">
    <div class="today-header">
        <h2>{{ __('teacher.dashboard.recent_announcements') }}</h2>
        <a href="/teacher/announcements">{{ __('common.view_all') }}</a>
    </div>

    @forelse($announcements as $announcement)
        <div class="today-item">
            <div class="today-left">
                <span class="time">{{ $announcement->created_at->format('M j, Y') }}</span>
                <h3>{{ $announcement->title }}</h3>
                <p>{{ $announcement->author->name ?? __('teacher.dashboard.school_fallback') }}</p>
            </div>
        </div>
    @empty
        <div class="today-item"><div class="today-left"><p>{{ __('teacher.dashboard.no_announcements_yet') }}</p></div></div>
    @endforelse
</div>

@endsection