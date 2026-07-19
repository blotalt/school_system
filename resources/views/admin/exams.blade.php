@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Exam Management</h1>
        <p>Managing {{ $exams->total() }} exams across all classes.</p>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <form method="GET" action="{{ route('admin.exams.index') }}" style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;width:100%;">
        <select name="class" class="filter-select" onchange="this.form.submit()">
            <option value="">All Classes</option>
            @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ (string) $classId === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.exams.create') }}" class="add-btn">
            <i class="fa-solid fa-plus"></i> Add Exam
        </a>
    </form>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Type</th>
                <th>Date</th>
                <th>Results</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td><strong>{{ $exam->title }}</strong></td>
                    <td>{{ $exam->schoolClass->name ?? 'Unassigned' }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td>{{ $exam->teacher->user->name ?? '—' }}</td>
                    <td><span class="badge badge-subject">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ \Illuminate\Support\Carbon::parse($exam->exam_date)->format('M j, Y') }}</td>
                    <td>{{ $exam->results_count }} / {{ $exam->schoolClass->students()->count() ?? 0 }}</td>
                    <td>
                        <a href="{{ route('admin.exams.results.index', $exam) }}" title="Enter Scores"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="{{ route('admin.exams.edit', $exam) }}" title="Edit" style="margin-left:12px;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this exam and all its results?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete" style="background:none;border:none;cursor:pointer;color:#9ca3af;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#9ca3af;padding:24px;">No exams found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $exams->links() }}
</div>
@endsection
