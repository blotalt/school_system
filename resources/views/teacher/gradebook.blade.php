@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>{{ __('teacher.gradebook.title') }}</h1>
        <p>{{ __('teacher.gradebook.subtitle') }}</p>
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
                <th>{{ __('teacher.gradebook.exam_column') }}</th>
                <th>{{ __('teacher.gradebook.class_column') }}</th>
                <th>{{ __('teacher.gradebook.subject_column') }}</th>
                <th>{{ __('teacher.gradebook.type_column') }}</th>
                <th>{{ __('teacher.gradebook.date_column') }}</th>
                <th>{{ __('teacher.gradebook.scored_column') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->schoolClass?->displayName() ?? '—' }}</td>
                    <td>{{ $exam->subject?->displayName() ?? '—' }}</td>
                    <td><span class="badge badge-subject">{{ __('teacher.exams.' . $exam->exam_type) }}</span></td>
                    <td>{{ \Illuminate\Support\Carbon::parse($exam->exam_date)->format('M j, Y') }}</td>
                    <td>{{ $exam->results_count }}</td>
                    <td>
                        <a href="{{ route('teacher.gradebook.show', $exam) }}" class="add-btn">
                            <i class="fa-solid fa-pen-to-square"></i> {{ __('teacher.gradebook.enter_scores') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;color:#8a94a6;">{{ __('teacher.gradebook.no_exams_yet') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection