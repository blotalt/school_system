@extends('layouts.admin')

@section('content')
<div class="page-title">
<h1>Exam Management</h1>
        <p>All exams across the school, created by teachers.</p>
</div>

@if(session('success'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Exam Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Type</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td><strong>{{ $exam->title }}</strong></td>
                    <td>{{ $exam->schoolClass->name ?? '—' }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td>{{ $exam->teacher?->user?->name ?? '—' }}</td>
                    <td><span class="badge {{ $exam->exam_type === 'monthly' ? 'badge-science' : 'badge-geography' }}">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.exams.show', $exam) }}" title="View Results"><i class="fa-regular fa-eye"></i></a>
                        <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this exam?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#8a94a6;">No exams yet. Teachers create exams from their portal.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $exams->links() }}</div>
</div>
@endsection
