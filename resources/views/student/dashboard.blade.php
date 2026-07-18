@extends('layouts.student')

@section('content')
<x-page-header>
    <div>
        <h1>Welcome back{{ $student ? ', ' . auth()->user()->name : '' }}</h1>
        <p>
            @if($class)
                {{ $class->name }}{{ $class->track ? ' • ' . $class->track : '' }} • Academic Session 2025-2026
            @else
                Your student profile is not set up yet. Please contact the administrator.
            @endif
        </p>
    </div>
</x-page-header>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-value">{{ $attendanceRate }}%</div>
        <div class="stat-label">Attendance Rate</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-award"></i></div>
        <div class="stat-value">{{ $examCount }}</div>
        <div class="stat-label">Exam Results</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-book"></i></div>
        <div class="stat-value">{{ $homeworkCount }}</div>
        <div class="stat-label">Assigned Homework</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="stat-value">{{ $class?->teacher?->user?->name ?? '—' }}</div>
        <div class="stat-label">Homeroom Teacher</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Announcements</h3>
        <a href="/student/schedule">View Schedule</a>
    </div>
    @forelse($announcements as $a)
        <div class="announcement-card">
            <div class="announcement-icon navy"><i class="fa-solid fa-bullhorn"></i></div>
            <div class="announcement-content">
                <div class="announcement-top"><h3>{{ $a->title }}</h3></div>
                <div class="announcement-info">
                    <span><i class="fa-regular fa-calendar"></i> {{ $a->created_at->format('M d, Y') }}</span>
                    <span><i class="fa-regular fa-user"></i> {{ $a->author->name ?? 'School' }}</span>
                </div>
                <p>{{ $a->body }}</p>
                <div class="announcement-footer">
                    <span class="priority {{ $a->priority }}">{{ ucfirst($a->priority) }}</span>
                </div>
            </div>
        </div>
    @empty
        <p style="padding:16px;color:#8a94a6;">No announcements right now.</p>
    @endforelse
</div>
@endsection
