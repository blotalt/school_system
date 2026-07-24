@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('admin.exams.index') }}">{{ __('admin.exams.title') }}</a> &gt;
    <span>{{ __('admin.exams.results_breadcrumb', ['title' => $exam->title]) }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ $exam->title }}</h1>
        <p>{{ $exam->schoolClass->name ?? __('admin.exams.unassigned') }} &middot; {{ $exam->subject->name ?? '—' }} &middot; {{ __('admin.exams.max_score_suffix', ['score' => $exam->max_score]) }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('admin.exams.results.export', $exam) }}" class="add-btn">
            <i class="fa-solid fa-file-excel"></i> {{ __('admin.exams.export') }}
        </a>
        <a href="{{ route('admin.exams.results.export.pdf', $exam) }}" class="add-btn" style="background:#dc2626;">
            <i class="fa-solid fa-file-pdf"></i> {{ __('admin.exams.export_pdf') }}
        </a>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="session-card">
    <div>
        <span class="session-label">{{ __('admin.exams.exam_details') }}</span>
        <h1 style="font-size:22px;">{{ ucfirst($exam->exam_type) }} {{ __('admin.exams.exam_type_suffix') }}</h1>
        <div class="session-info">
            <span><i class="fa-regular fa-calendar"></i> {{ \Illuminate\Support\Carbon::parse($exam->exam_date)->format('F j, Y') }}</span>
            <span><i class="fa-solid fa-chalkboard-user"></i> {{ $exam->teacher->user->name ?? '—' }}</span>
            <span><i class="fa-regular fa-chart-bar"></i> {{ __('admin.exams.average', ['value' => $average ?? '—']) }}</span>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.exams.results.store', $exam) }}">
    @csrf
    <div class="attendance-card">
        <div class="attendance-header">
            <span class="student-column">{{ __('common.student') }}</span>
            <span class="status-column">{{ __('admin.exams.score_out_of', ['max' => $exam->max_score]) }}</span>
        </div>

        @forelse($students as $student)
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle">{{ strtoupper(substr($student->user->name, 0, 1)) }}</div>
                    <div>
                        <h4>{{ $student->user->name }}</h4>
                        <p>{{ $student->roll_no }}</p>
                    </div>
                </div>
                <div>
                    <input type="number" name="scores[{{ $student->id }}]" min="0" max="{{ $exam->max_score }}"
                        value="{{ old('scores.' . $student->id, $scores->get($student->id)) }}"
                        style="width:100px;height:40px;border:1px solid #e5e9f2;border-radius:8px;padding:0 12px;text-align:center;">
                </div>
            </div>
        @empty
            <div class="student-row" style="justify-content:center;color:#9ca3af;">{{ __('admin.attendance.no_students_in_class') }}</div>
        @endforelse

        <div class="attendance-footer">
            <span style="color:#9ca3af;font-size:14px;">{{ __('admin.exams.scored_of', ['scored' => $scores->count(), 'total' => $students->count()]) }}</span>
            <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> {{ __('admin.exams.save_scores') }}</button>
        </div>
    </div>
</form>
@endsection
