@extends('layouts.teacher')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('teacher.homework.index') }}">Homework</a> &gt;
    <span>Edit</span>
</div>

<div class="page-title">
<h1>Edit Homework</h1>
        <p>Update the assignment details.</p>
</div>

<form method="POST" action="{{ route('teacher.homework.update', $homework) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $homework->title) }}">
            @error('title') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Due Date</label>
            <input type="date" name="due_date" value="{{ old('due_date', optional($homework->due_date)->format('Y-m-d')) }}">
            @error('due_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Class</label>
            <select name="class_id">
                <option value="">Select a class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id', $homework->class_id) == $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id">
                <option value="">Select a subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected(old('subject_id', $homework->subject_id) == $subject->id)>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Description (optional)</label>
        <textarea name="description" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;">{{ old('description', $homework->description) }}</textarea>
        @error('description') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('teacher.homework.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</form>
@endsection
