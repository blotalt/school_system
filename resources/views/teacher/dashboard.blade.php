@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>Welcome, {{ $teacher?->user->name ?? auth()->user()->name }}</h1>
        <p>Here's an overview of your classes today.</p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-school"></i></div>
        <div class="stat-value">{{ $classes->count() }}</div>
        <div class="stat-label">My Classes</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
        <div class="stat-value">{{ number_format($studentCount) }}</div>
        <div class="stat-label">Total Students</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-regular fa-clipboard"></i></div>
        <div class="stat-value">{{ number_format($examCount) }}</div>
        <div class="stat-label">Exams Created</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-value">{{ $attendanceRate }}%</div>
        <div class="stat-label">Attendance Rate</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>My Classes</h3>
        <a href="/teacher/classes">View All</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Track</th>
                <th>Students</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->track ?? 'General' }}</td>
                    <td>{{ $class->students_count }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;color:#8a94a6;">No classes assigned yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="today-card">
    <div class="today-header">
        <h2>Today's Schedule</h2>
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
        <div class="today-item"><div class="today-left"><p>No classes scheduled today.</p></div></div>
    @endforelse
</div>

<div class="today-card" style="margin-top:20px;">
    <div class="today-header">
        <h2>Recent Announcements</h2>
        <a href="/teacher/announcements">View All</a>
    </div>

    @forelse($announcements as $announcement)
        <div class="today-item">
            <div class="today-left">
                <span class="time">{{ $announcement->created_at->format('M j, Y') }}</span>
                <h3>{{ $announcement->title }}</h3>
                <p>{{ $announcement->author->name ?? 'School' }}</p>
            </div>
        </div>
    @empty
        <div class="today-item"><div class="today-left"><p>No announcements yet.</p></div></div>
    @endforelse
</div>

@endsection
