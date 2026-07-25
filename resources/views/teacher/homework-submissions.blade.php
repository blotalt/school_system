@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('teacher.homework.index') }}">{{ __('teacher.homework.title') }}</a> &gt;
    <span>{{ __('teacher.homework.submissions_title') }}</span>
</div>

<div class="gradebook-page">
    <div class="gradebook-header">
        <div class="header-left">
            <h1>{{ __('teacher.homework.submissions_title') }}</h1>
            <p>{{ $homework->title }} &mdash; <span>{{ $homework->schoolClass->name ?? '—' }}</span></p>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('teacher.homework.submissions.grade', $homework) }}">
    @csrf
    <div class="gradebook-card">
        <table class="gradebook-table">
            <thead>
                <tr>
                    <th>{{ __('common.student') }}</th>
                    <th>{{ __('teacher.homework.submission_column') }}</th>
                    <th>{{ __('teacher.homework.score_column') }}</th>
                    <th>{{ __('teacher.homework.feedback_column') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php $submission = $submissions->get($student->id); @endphp
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="avatar-circle" style="width:36px;height:36px;">{{ strtoupper(substr($student->user->name, 0, 2)) }}</div>
                                <div>
                                    <h4>{{ $student->user->name }}</h4>
                                    <p>{{ $student->roll_no }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($submission)
                                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">
                                    <i class="fa-solid fa-paperclip"></i> {{ $submission->file_name }}
                                </a>
                                <div style="color:#8a94a6;font-size:12px;">{{ __('teacher.homework.submitted_on', ['date' => $submission->submitted_at->format('M j, Y g:i A')]) }}</div>
                            @else
                                <span style="color:#c4c9d4;">{{ __('teacher.homework.not_submitted') }}</span>
                            @endif
                        </td>
                        <td>
                            <input type="number" name="scores[{{ $student->id }}]" class="score-input"
                                min="0" max="100" @disabled(!$submission)
                                value="{{ old('scores.' . $student->id, $submission->score ?? '') }}">
                        </td>
                        <td>
                            <textarea name="feedback[{{ $student->id }}]" rows="2" @disabled(!$submission)
                                placeholder="{{ __('teacher.homework.feedback_placeholder') }}"
                                style="width:100%;border:1px solid #e5e9f2;border-radius:8px;padding:8px;">{{ old('feedback.' . $student->id, $submission->feedback ?? '') }}</textarea>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#8a94a6;">{{ __('teacher.gradebook.no_students_in_class') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="gradebook-footer">
        <div class="footer-text">{{ __('teacher.homework.graded_of', ['graded' => $submissions->whereNotNull('graded_at')->count(), 'total' => $students->count()]) }}</div>
        <div class="footer-buttons">
            <a href="{{ route('teacher.homework.index') }}" class="discard-btn">{{ __('teacher.homework.back_to_homework') }}</a>
            <button type="submit" class="save-btn">{{ __('teacher.homework.save_grades') }}</button>
        </div>
    </div>
</form>

@endsection
