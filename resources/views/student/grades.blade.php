@extends('layouts.student')

@section('content')

@php
$subjectIcons = [
    'Mathematics' => 'fa-square-root-variable', 'Physics' => 'fa-flask',
    'Chemistry' => 'fa-vial', 'Biology' => 'fa-dna', 'English' => 'fa-globe',
    'History' => 'fa-landmark', 'Geography' => 'fa-earth-asia', 'Computer Science' => 'fa-laptop-code',
];

$gradeLetter = function (?float $pct): string {
    if ($pct === null) return '—';
    return match(true) {
        $pct >= 90 => 'A', $pct >= 80 => 'B', $pct >= 70 => 'C', $pct >= 60 => 'D', default => 'F',
    };
};

$gradeColor = function (?float $pct): string {
    if ($pct === null) return 'blue';
    return match(true) {
        $pct >= 90 => 'green', $pct >= 70 => 'blue', default => 'orange',
    };
};
@endphp

<div class="grade-dashboard">
    <div class="welcome-card">
        <div class="welcome-left">
            <div class="avatar-circle" style="width:64px;height:64px;font-size:20px;">
                {{ collect(explode(' ', $student?->user->name ?? auth()->user()->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
            </div>
            <div>
                <h1>Hello, {{ $student?->user->name ?? auth()->user()->name }}</h1>
                <div class="student-badges">
                    <span class="grade-badge">{{ $class->name ?? 'Unassigned' }}</span>
                    @if($class?->track)
                        <span class="track-badge">{{ $class->track }} Track</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon"><i class="fa-regular fa-calendar-check"></i></div>
            </div>
            <h5>ATTENDANCE RATE</h5>
            <h2>{{ $attendanceRate }}%</h2>
        </div>

        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon"><i class="fa-solid fa-book"></i></div>
            </div>
            <h5>OVERALL GRADE</h5>
            <h2>{{ $gradeLetter($averageScore) }}</h2>
        </div>

        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon"><i class="fa-regular fa-star"></i></div>
            </div>
            <h5>AVERAGE SCORE</h5>
            <h2>{{ $averageScore ?? '—' }}<small>/100</small></h2>
        </div>
    </div>
</div>

<div class="performance-card">
    <div class="performance-header">
        <h2>Recent Academic Performance</h2>
    </div>

    <table class="performance-table">
        <thead>
            <tr>
                <th>SUBJECT</th>
                <th>SCORE</th>
                <th>GRADE</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $result)
                @php
                    $pct = $result->exam->max_score > 0 ? round($result->score / $result->exam->max_score * 100, 1) : null;
                    $icon = $subjectIcons[$result->exam->subject->name ?? ''] ?? 'fa-book-open';
                @endphp
                <tr>
                    <td>
                        <div class="subject-cell">
                            <div class="subject-icon"><i class="fa-solid {{ $icon }}"></i></div>
                            <div>
                                <h4>{{ $result->exam->subject->name ?? '—' }}</h4>
                                <p>{{ $result->exam->title }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="progress-box">
                            <div class="progress-fill" style="width:{{ $pct ?? 0 }}%;"></div>
                        </div>
                        <span>{{ $result->score }}/{{ $result->exam->max_score }}</span>
                    </td>
                    <td>
                        <span class="grade {{ $gradeColor($pct) }}">{{ $gradeLetter($pct) }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;color:#8a94a6;">No exam results yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
