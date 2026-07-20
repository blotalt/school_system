@extends('layouts.student')

@section('content')
<div class="page-title">
<h1>My Grades</h1>
        <p>Your exam results, read-only.</p>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Exam Results</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Exam</th>
                <th>Type</th>
                <th>Score</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $result)
                @php
                    $max = $result->exam->max_score ?? 0;
                    $pct = $max > 0 ? round($result->score / $max * 100, 1) : 0;
                @endphp
                <tr>
                    <td>{{ $result->exam->subject->name ?? '—' }}</td>
                    <td>{{ $result->exam->title ?? '—' }}</td>
                    <td><span class="badge">{{ ucfirst($result->exam->exam_type ?? '') }}</span></td>
                    <td>{{ $result->score }} / {{ $max }}</td>
                    <td>{{ $pct }}%</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#8a94a6;">No grades recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
