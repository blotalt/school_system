@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Edit Class</h1>
        <p>Update details for {{ $class->name }}.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.classes.update', $class) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group">
            <label>Class Name</label>
            <input type="text" name="name" value="{{ old('name', $class->name) }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Grade Level</label>
            <input type="text" name="grade_level" value="{{ old('grade_level', $class->grade_level) }}">
            @error('grade_level') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Track</label>
            <select name="track">
                <option value="">No track</option>
                <option value="Science" @selected(old('track', $class->track) === 'Science')>Science</option>
                <option value="Social Science" @selected(old('track', $class->track) === 'Social Science')>Social Science</option>
                <option value="Arts" @selected(old('track', $class->track) === 'Arts')>Arts</option>
                <option value="Commerce" @selected(old('track', $class->track) === 'Commerce')>Commerce</option>
            </select>
            @error('track') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Homeroom Teacher</label>
            <select name="teacher_id">
                <option value="">Unassigned</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('teacher_id', $class->teacher_id) == $teacher->id)>
                        {{ $teacher->user->name }}{{ $teacher->subject_specialty ? ' — ' . $teacher->subject_specialty : '' }}
                    </option>
                @endforeach
            </select>
            @error('teacher_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.classes.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</form>
@endsection