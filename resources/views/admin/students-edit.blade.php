@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.students.index') }}">Students</a> &gt;
    <span>Edit Student</span>
</div>

<x-page-header>
    <div>
        <h1>Edit Student</h1>
        <p>Update enrollment details for {{ $student->user->name }}.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.students.update', $student) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name', $student->user->name) }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email', $student->user->email) }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Roll Number</label>
            <input type="text" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}">
            @error('roll_no') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}">
            @error('date_of_birth') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Guardian Contact</label>
        <input type="text" name="guardian_contact" value="{{ old('guardian_contact', $student->guardian_contact) }}">
        @error('guardian_contact') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Assigned Class</label>
        <div class="section-toggle-group">
            @foreach($classes as $class)
                <label class="section-toggle">
                    <input type="radio" name="class_id" value="{{ $class->id }}" {{ (string) old('class_id', $student->class_id) === (string) $class->id ? 'checked' : '' }}>
                    <span>{{ $class->name }}</span>
                </label>
            @endforeach
        </div>
        @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.students.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</form>
@endsection
