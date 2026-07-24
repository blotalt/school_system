@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('teacher.exams.index') }}">{{ __('teacher.exams.title') }}</a> &gt;
    <span>{{ __('teacher.exams.create_title') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('teacher.exams.create_title') }}</h1>
        <p>{{ __('teacher.exams.create_subtitle') }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('teacher.exams.store') }}" class="form-card">
    @csrf

    <div class="form-group">
        <label>{{ __('teacher.exams.exam_title_label') }}</label>
        <input type="text" name="title" placeholder="{{ __('teacher.exams.exam_title_placeholder') }}" value="{{ old('title') }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row form-row-3">
        <div class="form-group">
            <label>{{ __('common.class') }}</label>
            <select name="class_id">
                <option value="">{{ __('teacher.exams.select_class') }}</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) old('class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.subject') }}</label>
            @if($subjects->count() === 1)
                <input type="text" value="{{ $subjects->first()->name }}" disabled>
                <input type="hidden" name="subject_id" value="{{ $subjects->first()->id }}">
            @elseif($subjects->count() > 1)
                <select name="subject_id">
                    <option value="">{{ __('teacher.exams.select_subject') }}</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ (string) old('subject_id') === (string) $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            @else
                <input type="text" value="{{ __('teacher.exams.no_subject_assigned') }}" disabled>
            @endif
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('teacher.exams.exam_type') }}</label>
            <select name="exam_type">
                <option value="monthly" {{ old('exam_type', 'monthly') === 'monthly' ? 'selected' : '' }}>{{ __('teacher.exams.monthly') }}</option>
                <option value="semester" {{ old('exam_type') === 'semester' ? 'selected' : '' }}>{{ __('teacher.exams.semester') }}</option>
            </select>
            @error('exam_type') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('teacher.exams.exam_date') }}</label>
            <input type="date" name="exam_date" value="{{ old('exam_date') }}">
            @error('exam_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('teacher.exams.max_score') }}</label>
            <input type="number" name="max_score" min="1" value="{{ old('max_score', 100) }}">
            @error('max_score') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="info-box">
        <i class="fa-solid fa-circle-info"></i>
        <span>{{ __('teacher.exams.create_notice') }}</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.exams.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn" {{ $subjects->isEmpty() ? 'disabled' : '' }}>{{ __('teacher.exams.create_exam') }}</button>
    </div>
</form>

@endsection
