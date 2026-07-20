@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.teachers.index') }}">Teachers</a> &gt;
    <span>Add New Teacher</span>
</div>

<div class="page-title">
<h1>Teacher Registration</h1>
        <p>Register a new faculty member for the Academic Year 2025-2026.</p>
</div>

<form method="POST" action="{{ route('admin.teachers.store') }}" class="form-card">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="e.g. Socheata Vorn" value="{{ old('name') }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="teacher@school.test" value="{{ old('email') }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>System Password</label>
            <input type="password" name="password" placeholder="••••••••">
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Subject Specialty</label>
            <input type="text" name="subject_specialty" placeholder="e.g. Mathematics" value="{{ old('subject_specialty') }}">
            @error('subject_specialty') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.teachers.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-user-plus"></i> Register Teacher</button>
    </div>
</form>
@endsection
