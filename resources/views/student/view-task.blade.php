@extends('layouts.student')

@section('content')

@php $overdue = $homework->due_date && $homework->due_date->isPast(); @endphp

<div class="breadcrumb">
    <a href="{{ route('student.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('student.homework.index') }}">{{ __('student.homework.title') }}</a> &gt;
    <span>{{ $homework->title }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ $homework->title }}</h1>
        <p>{{ $homework->subject?->displayName() ?? '—' }} &middot; {{ $homework->schoolClass->name ?? '—' }}</p>
    </div>
</x-page-header>

<div class="data-card" style="padding:30px;">
    <div class="stat-grid" style="margin-bottom:24px;">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-regular fa-calendar"></i></div>
            <div class="stat-value" style="font-size:18px;">{{ $homework->due_date->format('M j, Y') }}</div>
            <div class="stat-label">{{ __('student.view_task.due_date') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-value" style="font-size:18px;">
                <span class="badge {{ $overdue ? 'badge-geography' : 'badge-science' }}">{{ $overdue ? __('student.view_task.past_due') : __('student.view_task.upcoming') }}</span>
            </div>
            <div class="stat-label">{{ __('student.view_task.status') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-regular fa-user"></i></div>
            <div class="stat-value" style="font-size:18px;">{{ $homework->teacher->user->name ?? '—' }}</div>
            <div class="stat-label">{{ __('student.view_task.assigned_by') }}</div>
        </div>
    </div>

    <h3 style="margin-bottom:12px;">{{ __('student.view_task.description') }}</h3>
    <p style="color:#4b5563;line-height:1.6;">{{ $homework->description ?: __('student.view_task.no_description') }}</p>

    @if($homework->attachment_path)
        <div style="margin-top:24px;">
            <a href="{{ asset('storage/' . $homework->attachment_path) }}" target="_blank" class="add-btn">
                <i class="fa-solid fa-paperclip"></i> {{ $homework->attachment_name }}
            </a>
        </div>
    @endif
</div>

@if (session('success'))
    <div class="alert alert-success" style="margin:16px 0;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card" style="padding:30px;margin-top:20px;">
    <h3 style="margin-bottom:16px;">{{ __('student.view_task.submission_heading') }}</h3>

    @if($submission)
        @php $late = $submission->submitted_at && $homework->due_date && $submission->submitted_at->gt($homework->due_date->endOfDay()); @endphp
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:12px;">
            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="add-btn">
                <i class="fa-solid fa-paperclip"></i> {{ $submission->file_name }}
            </a>
            <span style="color:#8a94a6;font-size:13px;">{{ __('student.view_task.submitted_on', ['date' => $submission->submitted_at->format('M j, Y g:i A')]) }}</span>
            @if($late)
                <span class="badge badge-geography">{{ __('student.view_task.late_badge') }}</span>
            @endif
            @if($submission->graded_at)
                <span class="badge badge-science">{{ __('student.view_task.graded_badge') }}</span>
            @else
                <span class="badge">{{ __('student.view_task.pending_grade_badge') }}</span>
            @endif
        </div>

        @if($submission->graded_at)
            <div style="background:#f7f9fc;border-radius:10px;padding:16px;margin-bottom:20px;">
                <div style="font-weight:600;margin-bottom:6px;">{{ __('student.view_task.your_score') }}: {{ $submission->score }}/100</div>
                @if($submission->feedback)
                    <div style="color:#4b5563;">
                        <strong>{{ __('student.view_task.feedback_label') }}:</strong> {{ $submission->feedback }}
                    </div>
                @endif
            </div>
        @endif
    @else
        <p style="color:#8a94a6;margin-bottom:16px;">{{ __('student.view_task.not_submitted_yet') }}</p>
    @endif

    <form method="POST" action="{{ route('student.homework.submit', $homework) }}" enctype="multipart/form-data" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        @csrf
        <input type="file" name="submission" accept=".pdf,.jpg,.jpeg,.png" required>
        <button type="submit" class="save-btn">
            {{ $submission ? __('student.view_task.resubmit_work') : __('student.view_task.submit_work') }}
        </button>
    </form>
    @error('submission') <span class="field-error">{{ $message }}</span> @enderror
    <p style="color:#9ca3af;font-size:13px;margin-top:8px;">
        {{ __('student.view_task.upload_hint') }}
        @if($submission) &middot; {{ __('student.view_task.resubmit_notice') }} @endif
    </p>
</div>

@endsection
