@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>Gradebook</h1>
        <p>Select an exam to view or enter student scores.</p>
    </div>
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
                <th>Exam</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Date</th>
                <th>Scored</th>
                <th></th>
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
                        <a href="{{ route('teacher.gradebook.show', $exam) }}" class="add-btn">
                            <i class="fa-solid fa-pen-to-square"></i> Enter Scores
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#8a94a6;">You haven't created any exams yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
