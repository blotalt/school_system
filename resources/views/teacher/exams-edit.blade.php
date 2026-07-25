@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('teacher.exams.index') }}">{{ __('teacher.exams.title') }}</a> &gt;
    <span>{{ __('teacher.exams.edit_breadcrumb') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('teacher.exams.edit_title') }}</h1>
        <p>{{ $exam->schoolClass->name ?? '' }} &middot; {{ $exam->subject->name ?? '' }} &middot; {{ ucfirst($exam->exam_type) }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('teacher.exams.update', $exam) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>{{ __('teacher.exams.exam_title_label') }}</label>
        <input type="text" name="title" value="{{ old('title', $exam->title) }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('teacher.exams.exam_date') }}</label>
            <input type="date" name="exam_date" value="{{ old('exam_date', \Illuminate\Support\Carbon::parse($exam->exam_date)->format('Y-m-d')) }}">
            @error('exam_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('teacher.exams.max_score') }}</label>
            <input type="number" name="max_score" min="1" value="{{ old('max_score', $exam->max_score) }}">
            @error('max_score') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="info-box">
        <i class="fa-solid fa-circle-info"></i>
        <span>{{ __('teacher.exams.edit_notice') }}</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.exams.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn">{{ __('common.save_changes') }}</button>
    </div>
</form>

@endsection
