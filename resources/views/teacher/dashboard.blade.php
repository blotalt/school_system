@extends('layouts.teacher')

@section('content')
<x-page-header>
    <div>
        <h1>Teacher Dashboard</h1>
        <p>{{ $teacher ? 'Your classes and activity' : 'Your teacher profile is not set up yet.' }}</p>
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
        <div class="stat-value">{{ $studentCount }}</div>
        <div class="stat-label">My Students</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-regular fa-clipboard"></i></div>
        <div class="stat-value">{{ $examCount }}</div>
        <div class="stat-label">My Exams</div>
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
                    <td><span class="badge badge-{{ strtolower($class->track ?? 'general') }}">{{ strtoupper($class->track ?? 'General') }}</span></td>
                    <td>{{ $class->students_count }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;color:#8a94a6;">No classes assigned yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Announcements</h3>
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
            </div>
        </div>
    @empty
        <p style="padding:16px;color:#8a94a6;">No announcements right now.</p>
    @endforelse
</div>
@endsection
