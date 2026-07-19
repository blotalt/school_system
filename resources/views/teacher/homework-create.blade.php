@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('teacher.homework.index') }}">Homework</a> &gt;
    <span>Assign Homework</span>
</div>

<x-page-header>
    <div>
        <h1>Assign Homework</h1>
        <p>Set a new homework assignment for one of your classes.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('teacher.homework.store') }}" class="form-card">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label>Class</label>
            <select name="class_id">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) old('class_id') === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id">
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ (string) old('subject_id') === (string) $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Chapter 4 Practice Problems">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;">{{ old('description') }}</textarea>
        @error('description') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="max-width:300px;">
        <label>Due Date</label>
        <input type="date" name="due_date" value="{{ old('due_date') }}">
        @error('due_date') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.homework.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn">Assign Homework</button>
    </div>
</form>

@endsection
