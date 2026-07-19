@extends('layouts.student')

@section('content')

<div class="welcome-card">
    <div class="welcome-left">
        <div class="avatar-circle" style="width:64px;height:64px;font-size:20px;">
            {{ collect(explode(' ', $student?->user->name ?? auth()->user()->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
        </div>
        <div>
            <h1>Hello, {{ $student?->user->name ?? auth()->user()->name }}</h1>
            <div class="student-badge">
                <span class="grade-badge">{{ $class->name ?? 'Unassigned' }}</span>
                @if($class?->track)
                    <span class="track-badge">{{ $class->track }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-value">{{ $attendanceRate }}%</div>
        <div class="stat-label">Attendance Rate</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-regular fa-clipboard"></i></div>
        <div class="stat-value">{{ number_format($examCount) }}</div>
        <div class="stat-label">Exam Results</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-book"></i></div>
        <div class="stat-value">{{ number_format($homeworkCount) }}</div>
        <div class="stat-label">Homework Assigned</div>
    </div>
</div>

<div class="today-card">
    <div class="today-header">
        <h2>Today's Schedule</h2>
    </div>

    @forelse($todaySchedule as $slot)
        <div class="today-item">
            <div class="today-left">
                <span class="today-time">{{ $slot->time }}</span>
                <h3>{{ $slot->subject }}</h3>
                <p><i class="fa-regular fa-user"></i> {{ $slot->teacher }}</p>
            </div>
        </div>
    @empty
        <div class="today-item"><div class="today-left"><p>No classes scheduled today.</p></div></div>
    @endforelse
</div>

<div class="today-card" style="margin-top:20px;">
    <div class="today-header">
        <h2>Recent Announcements</h2>
        <a href="/student/announcements">View All</a>
    </div>

    @forelse($announcements as $announcement)
        <div class="today-item">
            <div class="today-left">
                <span class="today-time">{{ $announcement->created_at->format('M j, Y') }}</span>
                <h3>{{ $announcement->title }}</h3>
                <p>{{ $announcement->author->name ?? 'School' }}</p>
            </div>
        </div>
    @empty
        <div class="today-item"><div class="today-left"><p>No announcements yet.</p></div></div>
    @endforelse
</div>

@endsection
