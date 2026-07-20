@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.teachers.index') }}">Teachers</a> &gt;
    <span>Edit Teacher</span>
</div>

<div class="page-title">
<h1>Edit Teacher</h1>
        <p>Update the details for {{ $teacher->user->name }}.</p>
</div>

<form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="form-card">
    @csrf
    @method('PUT')

    <div class="form-row">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name', $teacher->user->name) }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group" style="max-width:400px;">
        <label>Subject Specialty</label>
        <input type="text" name="subject_specialty" value="{{ old('subject_specialty', $teacher->subject_specialty) }}">
        @error('subject_specialty') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.teachers.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</form>
@endsection
