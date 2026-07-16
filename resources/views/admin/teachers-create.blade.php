@extends('layouts.admin')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('admin.teachers.index') }}">Teachers</a> &gt;
    <span>Add New Teacher</span>
</div>

<x-page-header>
    <div>
        <h1>Teacher Registration</h1>
        <p>Register a new faculty member into the system for the Academic Year 2025-2026.</p>
    </div>
</x-page-header>

<form method="POST" action="#" class="form-card">
    @csrf

    <h3 class="form-section-title"><i class="fa-solid fa-briefcase"></i> Faculty Information</h3>

    <div class="form-row form-row-3">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="e.g. Socheata Vorn" value="{{ old('name') }}">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob') }}">
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="vorn.s@cambodiahigh.edu" value="{{ old('email') }}">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="12 345 678" value="{{ old('phone') }}">
        </div>
    </div>

    <div class="form-group" style="max-width:400px;">
        <label>System Password</label>
        <input type="password" name="password" placeholder="••••••••">
        @error('password') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <hr class="form-divider">

    <div class="form-group">
        <label>Subject Specialization</label>
        <div class="section-toggle-group">
            @foreach(['Math','Physics','Biology','History','English'] as $subject)
                <label class="section-toggle">
                    <input type="checkbox" name="subjects[]" value="{{ $subject }}">
                    <span>{{ $subject }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="form-group">
        <label>Assigned Classes</label>
        <div class="section-toggle-group">
            @foreach(['10A','10B','10C','11A','11B','11C','12A','12B','12C'] as $section)
                <label class="section-toggle">
                    <input type="checkbox" name="classes[]" value="{{ $section }}">
                    <span>{{ $section }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="info-box">
        <i class="fa-solid fa-circle-info"></i>
        <span>Official faculty IDs and institution email aliases are generated automatically based on the registration name and assigned department. These will be sent to the provided email address upon activation.</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.teachers.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-user-plus"></i> Register Teacher</button>
    </div>
</form>
@endsection