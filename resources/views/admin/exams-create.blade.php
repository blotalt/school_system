@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('admin.exams.index') }}">{{ __('admin.exams.title') }}</a> &gt;
    <span>{{ __('admin.exams.add_new') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('admin.exams.create_title') }}</h1>
        <p>{{ __('admin.exams.create_subtitle') }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.exams.store') }}" class="form-card">
    @csrf

    <div class="form-group">
        <label>{{ __('admin.exams.exam_title_label') }}</label>
        <input type="text" name="title" placeholder="{{ __('admin.exams.exam_title_placeholder') }}" value="{{ old('title') }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row form-row-3">
        <div class="form-group">
            <label>{{ __('common.class') }}</label>
            <select name="class_id">
                <option value="">{{ __('admin.exams.select_class_option') }}</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) old('class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.subject') }}</label>
            <select name="subject_id">
                <option value="">{{ __('admin.exams.select_subject_option') }}</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ (string) old('subject_id') === (string) $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.teacher') }}</label>
            <select name="teacher_id">
                <option value="">{{ __('admin.exams.select_teacher_option') }}</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ (string) old('teacher_id') === (string) $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                @endforeach
            </select>
            @error('teacher_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('admin.exams.exam_type') }}</label>
            <select name="exam_type">
                <option value="monthly" {{ old('exam_type', 'monthly') === 'monthly' ? 'selected' : '' }}>{{ __('admin.exams.monthly') }}</option>
                <option value="semester" {{ old('exam_type') === 'semester' ? 'selected' : '' }}>{{ __('admin.exams.semester') }}</option>
            </select>
            @error('exam_type') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('admin.exams.exam_date') }}</label>
            <input type="date" name="exam_date" value="{{ old('exam_date') }}">
            @error('exam_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('admin.exams.max_score') }}</label>
            <input type="number" name="max_score" min="1" value="{{ old('max_score', 100) }}">
            @error('max_score') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.exams.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-plus"></i> {{ __('admin.exams.create_button') }}</button>
    </div>
</form>
@endsection
