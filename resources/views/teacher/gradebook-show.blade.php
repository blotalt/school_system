@extends('layouts.teacher')

@section('content')

<div class="gradebook-page">
    <div class="gradebook-header">
        <div class="header-left">
            <h1>Gradebook</h1>
            <p>{{ $exam->title }} &mdash; <span>{{ $exam->schoolClass->name ?? '—' }}</span></p>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('teacher.gradebook.store', $exam) }}">
    @csrf
    <div class="gradebook-card">
        <table class="gradebook-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Subject</th>
                    <th>Score (0-{{ $exam->max_score }})</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $score = $scores->get($student->id);
                        $pct = $score !== null && $exam->max_score > 0 ? $score / $exam->max_score * 100 : null;
                        $grade = match(true) {
                            $pct === null => null,
                            $pct >= 90 => 'a', $pct >= 80 => 'b', $pct >= 70 => 'c', $pct >= 60 => 'd', default => 'f',
                        };
                    @endphp
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="avatar-circle" style="width:36px;height:36px;">{{ strtoupper(substr($student->user->name, 0, 2)) }}</div>
                                <div>
                                    <h4>{{ $student->user->name }}</h4>
                                    <p>{{ $student->roll_no }}</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="subject-badge">{{ $exam->subject->name ?? '—' }}</span></td>
                        <td>
                            <input type="number" name="scores[{{ $student->id }}]" class="score-input"
                                min="0" max="{{ $exam->max_score }}"
                                value="{{ old('scores.' . $student->id, $score) }}">
                        </td>
                        <td>
                            @if($grade)
                                <span class="grade-circle grade-{{ $grade }}">{{ strtoupper($grade) }}</span>
                            @else
                                <span class="grade-circle">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No students in this class.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="gradebook-footer">
        <div class="footer-text">{{ $scores->count() }} of {{ $students->count() }} students scored</div>
        <div class="footer-buttons">
            <a href="{{ route('teacher.gradebook.index') }}" class="discard-btn">Back to Exams</a>
            <button type="submit" class="save-btn">Save All Changes</button>
        </div>
    </div>
</form>

@endsection
