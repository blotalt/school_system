@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>My Exams</h1>
        <p>Exams you've created for your classes.</p>
    </div>
    <a href="{{ route('teacher.exams.create') }}" class="add-btn">
        <i class="fa-solid fa-plus"></i> Create Exam
    </a>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Date</th>
                <th>Scored</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->schoolClass->name ?? '—' }}</td>
                    <td>{{ $exam->subject->name ?? '—' }}</td>
                    <td><span class="badge badge-subject">{{ ucfirst($exam->exam_type) }}</span></td>
                    <td>{{ \Illuminate\Support\Carbon::parse($exam->exam_date)->format('M j, Y') }}</td>
                    <td>{{ $exam->results_count }}</td>
                    <td>
                        <a href="{{ route('teacher.gradebook.show', $exam) }}" title="Enter Scores"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="{{ route('teacher.exams.edit', $exam) }}" title="Edit" style="margin-left:12px;"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('teacher.exams.destroy', $exam) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this exam and all its results?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete" style="background:none;border:none;cursor:pointer;color:#9ca3af;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#8a94a6;">You haven't created any exams yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
