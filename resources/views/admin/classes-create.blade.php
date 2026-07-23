@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Add Class</h1>
        <p>Create a new class and assign a homeroom teacher.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.classes.store') }}" class="form-card">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label>Class Name</label>
            <input type="text" name="name" placeholder="e.g. Grade 10-A" value="{{ old('name') }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Grade Level</label>
            <input type="text" name="grade_level" placeholder="e.g. 10" value="{{ old('grade_level') }}">
            @error('grade_level') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Track</label>
            <select name="track">
                <option value="">No track</option>
                <option value="Science" @selected(old('track') === 'Science')>Science</option>
                <option value="Social Science" @selected(old('track') === 'Social Science')>Social Science</option>
                <option value="Arts" @selected(old('track') === 'Arts')>Arts</option>
                <option value="Commerce" @selected(old('track') === 'Commerce')>Commerce</option>
            </select>
            @error('track') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Homeroom Teacher</label>
            <select name="teacher_id">
                <option value="">Unassigned</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>
                        {{ $teacher->user->name }}{{ $teacher->subject_specialty ? ' — ' . $teacher->subject_specialty : '' }}
                    </option>
                @endforeach
            </select>
            @error('teacher_id') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.classes.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-plus"></i> Create Class</button>
    </div>
</form>
@endsection