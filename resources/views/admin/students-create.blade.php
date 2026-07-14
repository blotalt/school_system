@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.students.index') }}">Students</a> &gt;
    <span>Add New Student</span>
</div>

<x-page-header>
    <div>
        <h1>Student Registration</h1>
        <p>Enter the details to enroll a new student into the system.</p>
    </div>
</x-page-header>

<form method="POST" action="#" class="form-card">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="e.g. Serey Sokha" value="{{ old('name') }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="student@cambodiahigh.edu.kh" value="{{ old('email') }}">
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
            <label>Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="+855 000 000 000" value="{{ old('phone') }}">
        </div>
    </div>

    <div class="form-group">
        <label>Assigned Class Section</label>
        <div class="section-toggle-group">
            @foreach(['12A','12B','12C','11A','11B','11C','10A','10B','10C'] as $section)
                <label class="section-toggle">
                    <input type="radio" name="section" value="{{ $section }}" {{ old('section') === $section ? 'checked' : '' }}>
                    <span>{{ $section }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="info-box">
        <i class="fa-solid fa-lightbulb"></i>
        <span>Once registered, student IDs are automatically generated based on the current academic year (2025-2026). Student records will be available in the dashboard immediately.</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.students.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-user-plus"></i> Register Student</button>
    </div>
</form>
@endsection