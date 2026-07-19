@extends('layouts.student')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('student.dashboard') }}">Dashboard</a> &gt;
    <span>{{ $schedule->subject->name ?? 'Class' }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ $schedule->subject->name ?? '—' }}</h1>
        <p>{{ $schedule->schoolClass->name ?? '—' }} &middot; {{ $schedule->day_of_week }}, Period {{ $schedule->period }}</p>
    </div>
</x-page-header>

<div class="profile-wrapper">
    <div class="profile-left">
        <div class="profile-card">
            <div class="profile-image">
                <div class="avatar-circle" style="width:100px;height:100px;font-size:28px;">
                    {{ collect(explode(' ', $schedule->teacher->user->name ?? '—'))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                </div>
            </div>
            <h2>{{ $schedule->teacher->user->name ?? 'Unassigned' }}</h2>
            <span class="role-badge">Teacher</span>
            <hr>
            <div class="profile-info">
                <label>Subject</label>
                <h4>{{ $schedule->subject->name ?? '—' }}</h4>
            </div>
            <div class="profile-info">
                <label>Email</label>
                <h4>{{ $schedule->teacher->user->email ?? '—' }}</h4>
            </div>
        </div>
    </div>

    <div class="profile-right">
        <div class="data-card-header" style="padding:0 0 16px;">
            <h3>Classmates</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Roll No.</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classmates as $classmate)
                    <tr>
                        <td>{{ $classmate->user->name }}</td>
                        <td>{{ $classmate->roll_no }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" style="text-align:center;color:#8a94a6;">No classmates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
