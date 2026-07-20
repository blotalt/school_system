@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.exams.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Back to Exams
</a>

<div class="page-title">
<h1>{{ $exam->title }}</h1>
        <p>{{ $exam->schoolClass->name ?? '—' }} · {{ $exam->subject->name ?? '—' }} · Max Score: {{ $exam->max_score }}</p>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Roll No.</th>
                <th>Score</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exam->results as $result)
                @php $pct = $exam->max_score > 0 ? round($result->score / $exam->max_score * 100, 1) : 0; @endphp
                <tr>
                    <td>{{ $result->student?->user?->name ?? '—' }}</td>
                    <td>{{ $result->student?->roll_no ?? '—' }}</td>
                    <td>{{ $result->score }} / {{ $exam->max_score }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:80px;height:6px;background:#eef1f6;border-radius:10px;overflow:hidden;">
                                <div style="width:{{ $pct }}%;height:100%;background:{{ $pct < 50 ? '#ef4444' : '#10b981' }};"></div>
                            </div>
                            <span>{{ $pct }}%</span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No results recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
