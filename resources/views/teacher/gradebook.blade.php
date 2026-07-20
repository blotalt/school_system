@extends('layouts.teacher')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('teacher.exams.index') }}">Exams</a> &gt;
    <span>Gradebook</span>
</div>

<div class="page-title">
<h1>Gradebook</h1>
        <p>{{ $exam->title }} — {{ $class->name }} — Max: {{ $exam->max_score }}</p>
</div>

@if(session('success'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('teacher.gradebook.store', $exam) }}">
    @csrf

    <div class="gradebook-card">
        <table class="gradebook-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Score (0 – {{ $exam->max_score }})</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $score = $results->get($student->id)?->score ?? null;
                        $pct = ($score !== null && $exam->max_score > 0) ? round($score / $exam->max_score * 100) : null;
                        $grade = match(true) {
                            $pct === null => '—',
                            $pct >= 90   => 'A',
                            $pct >= 80   => 'B',
                            $pct >= 70   => 'C',
                            $pct >= 60   => 'D',
                            default      => 'F',
                        };
                        $gradeClass = match($grade) {
                            'A' => 'grade-a', 'B' => 'grade-b', 'C' => 'grade-c',
                            'D' => 'grade-d', 'F' => 'grade-f', default => '',
                        };
                    @endphp
                    <tr>
                        <td>
                            <div class="student-info">
                                <div>
                                    <h4>{{ $student->user->name }}</h4>
                                    <p>{{ $student->roll_no }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="score-input" name="scores[{{ $student->id }}]"
                                   value="{{ $score }}" min="0" max="{{ $exam->max_score }}"
                                   placeholder="—">
                        </td>
                        <td>
                            @if($grade !== '—')
                                <span class="grade-circle {{ $gradeClass }}">{{ $grade }}</span>
                            @else
                                <span style="color:#9ca3af;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align:center;color:#8a94a6;">No students in this class.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="gradebook-footer">
        <div class="footer-text">
            {{ $students->count() }} student(s) in {{ $class->name }}
        </div>
        <div class="footer-buttons">
            <a href="{{ route('teacher.exams.index') }}" class="discard-btn">Back to Exams</a>
            <button type="submit" class="save-btn">Save All Changes</button>
        </div>
    </div>
</form>
@endsection
