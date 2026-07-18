@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.teachers.index') }}">Teachers</a> &gt;
    <span>Edit Teacher</span>
</div>

<x-page-header>
    <div>
        <h1>Edit Teacher</h1>
        <p>Update faculty information for {{ $teacher->user->name }}.</p>
    </div>
</x-page-header>

<form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="form-card">
    @csrf
    @method('PUT')

    <h3 class="form-section-title"><i class="fa-solid fa-briefcase"></i> Faculty Information</h3>

    <div class="form-row form-row-3">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name', $teacher->user->name) }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($teacher->date_of_birth)->format('Y-m-d')) }}">
            @error('date_of_birth') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="male" @selected(old('gender', $teacher->gender) === 'male')>Male</option>
                <option value="female" @selected(old('gender', $teacher->gender) === 'female')>Female</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}">
            @error('phone') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group" style="max-width:400px;">
        <label>System Password</label>
        <input type="password" name="password" placeholder="Leave blank to keep current password">
        @error('password') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <hr class="form-divider">

    <div class="form-group">
        <label>Subject Specialization</label>
        <div class="section-toggle-group">
            @foreach($subjects as $subject)
                <label class="section-toggle">
                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" {{ in_array($subject->id, old('subjects', $assignedSubjectIds)) ? 'checked' : '' }}>
                    <span>{{ $subject->name }}</span>
                </label>
            @endforeach
        </div>
        @error('subjects') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Assigned Classes</label>
        <div class="section-toggle-group">
            @foreach($classes as $class)
                <label class="section-toggle">
                    <input type="checkbox" name="classes[]" value="{{ $class->id }}" {{ in_array($class->id, old('classes', $assignedClassIds)) ? 'checked' : '' }}>
                    <span>{{ $class->name }}</span>
                </label>
            @endforeach
        </div>
        @error('classes') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="info-box">
        <i class="fa-solid fa-circle-info"></i>
        <span>Assigning a class here reassigns it from any teacher currently teaching it.</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.teachers.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
</form>
@endsection
