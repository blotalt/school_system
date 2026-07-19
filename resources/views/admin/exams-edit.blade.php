@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.exams.index') }}">Exams</a> &gt;
    <span>Edit Exam</span>
</div>

<x-page-header>
    <div>
        <h1>Edit Exam</h1>
        <p>Update details for {{ $exam->title }}.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.exams.update', $exam) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Exam Title</label>
        <input type="text" name="title" value="{{ old('title', $exam->title) }}">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row form-row-3">
        <div class="form-group">
            <label>Class</label>
            <select name="class_id">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) old('class_id', $exam->class_id) === (string) $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ (string) old('subject_id', $exam->subject_id) === (string) $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Teacher</label>
            <select name="teacher_id">
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ (string) old('teacher_id', $exam->teacher_id) === (string) $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                @endforeach
            </select>
            @error('teacher_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Exam Type</label>
            <select name="exam_type">
                <option value="monthly" {{ old('exam_type', $exam->exam_type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="semester" {{ old('exam_type', $exam->exam_type) === 'semester' ? 'selected' : '' }}>Semester</option>
            </select>
            @error('exam_type') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Exam Date</label>
            <input type="date" name="exam_date" value="{{ old('exam_date', \Illuminate\Support\Carbon::parse($exam->exam_date)->format('Y-m-d')) }}">
            @error('exam_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Max Score</label>
            <input type="number" name="max_score" min="1" value="{{ old('max_score', $exam->max_score) }}">
            @error('max_score') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.exams.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</form>
@endsection
