@extends('layouts.student')

@section('content')
<div class="page-title">
<h1>My Schedule</h1>
        <p>Your class and upcoming exams.</p>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-school"></i></div>
        <div class="stat-value">{{ $class->name ?? '—' }}</div>
        <div class="stat-label">Class</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-layer-group"></i></div>
        <div class="stat-value">{{ $class->track ?? '—' }}</div>
        <div class="stat-label">Track</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="stat-value">{{ $class?->teacher?->user?->name ?? '—' }}</div>
        <div class="stat-label">Homeroom Teacher</div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Upcoming Exams</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Exam</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td><span class="badge">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No exams scheduled yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
