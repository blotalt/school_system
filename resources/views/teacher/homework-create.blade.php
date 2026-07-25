@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <a href="{{ route('teacher.homework.index') }}">{{ __('teacher.homework.title') }}</a> &gt;
    <span>{{ __('teacher.homework.assign_breadcrumb') }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ __('teacher.homework.assign_title') }}</h1>
        <p>{{ __('teacher.homework.assign_subtitle') }}</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('teacher.homework.store') }}" class="form-card" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label>{{ __('common.class') }}</label>
            <select name="class_id">
                <option value="">{{ __('teacher.homework.select_class') }}</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) old('class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->displayName() }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('common.subject') }}</label>
            <select name="subject_id">
                <option value="">{{ __('teacher.homework.select_subject') }}</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ (string) old('subject_id') === (string) $subject->id ? 'selected' : '' }}>{{ $subject->displayName() }}</option>
                @endforeach
            </select>
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>{{ __('common.title') }}</label>
        <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('teacher.homework.title_placeholder') }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>{{ __('teacher.homework.description') }}</label>
        <textarea name="description" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;">{{ old('description') }}</textarea>
        @error('description') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
        <div class="form-group" style="max-width:300px;">
            <label>{{ __('teacher.homework.due_date') }}</label>
            <input type="date" name="due_date" value="{{ old('due_date') }}">
            @error('due_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('teacher.homework.attachment') }} <span style="color:#9ca3af;font-weight:400;">{{ __('teacher.homework.attachment_hint') }}</span></label>
            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            @error('attachment') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.homework.index') }}" class="cancel-btn">{{ __('common.cancel') }}</a>
        <button type="submit" class="save-btn">{{ __('teacher.homework.assign_homework') }}</button>
    </div>
</form>

@endsection