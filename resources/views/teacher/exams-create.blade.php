@extends('layouts.teacher')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('teacher.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('teacher.exams.index') }}">Exams</a> &gt;
    <span>Create Exam</span>
</div>

<x-page-header>
    <div>
        <h1>Create Exam</h1>
        <p>Schedule a new exam for one of your classes.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('teacher.exams.store') }}" class="form-card">
    @csrf

    <div class="form-group">
        <label>Exam Title</label>
        <input type="text" name="title" placeholder="e.g. Monthly Math Exam" value="{{ old('title') }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row form-row-3">
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
        <div class="form-group">
            <label>Exam Type</label>
            <select name="exam_type">
                <option value="monthly" {{ old('exam_type', 'monthly') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="semester" {{ old('exam_type') === 'semester' ? 'selected' : '' }}>Semester</option>
            </select>
            @error('exam_type') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Exam Date</label>
            <input type="date" name="exam_date" value="{{ old('exam_date') }}">
            @error('exam_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Max Score</label>
            <input type="number" name="max_score" min="1" value="{{ old('max_score', 100) }}">
            @error('max_score') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="info-box">
        <i class="fa-solid fa-circle-info"></i>
        <span>You can only create exams for classes where you're the homeroom teacher.</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.exams.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn">Create Exam</button>
    </div>
</form>

@endsection
