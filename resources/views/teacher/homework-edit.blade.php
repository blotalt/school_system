@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('teacher.homework.index') }}">Homework</a> &gt;
    <span>Edit</span>
</div>

<x-page-header>
    <div>
        <h1>Edit Homework</h1>
        <p>Update this assignment's details.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('teacher.homework.update', $homework) }}" class="form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group">
            <label>Class</label>
            <select name="class_id">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) old('class_id', $homework->class_id) === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ (string) old('subject_id', $homework->subject_id) === (string) $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title', $homework->title) }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;">{{ old('description', $homework->description) }}</textarea>
        @error('description') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
        <div class="form-group" style="max-width:300px;">
            <label>Due Date</label>
            <input type="date" name="due_date" value="{{ old('due_date', $homework->due_date->format('Y-m-d')) }}">
            @error('due_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Attachment <span style="color:#9ca3af;font-weight:400;">(optional — PDF, Word, or image, max 10MB)</span></label>
            @if($homework->attachment_path)
                <div style="margin-bottom:8px;font-size:14px;">
                    <i class="fa-solid fa-paperclip"></i>
                    <a href="{{ asset('storage/' . $homework->attachment_path) }}" target="_blank">{{ $homework->attachment_name }}</a>
                    <label style="margin-left:12px;font-weight:400;color:#c0392b;">
                        <input type="checkbox" name="remove_attachment" value="1"> Remove
                    </label>
                </div>
            @endif
            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            @error('attachment') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.homework.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn">Save Changes</button>
    </div>
</form>

@endsection
