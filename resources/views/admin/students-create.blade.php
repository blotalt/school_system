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

<form method="POST" action="{{ route('admin.students.store') }}" class="form-card">
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
            <label>Roll Number</label>
            <input type="text" name="roll_no" placeholder="e.g. STU-006" value="{{ old('roll_no') }}">
            @error('roll_no') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Guardian Contact</label>
            <input type="text" name="guardian_contact" placeholder="+855 000 000 000" value="{{ old('guardian_contact') }}">
            @error('guardian_contact') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Assigned Class</label>
        <div class="section-toggle-group">
            @foreach($classes as $class)
                <label class="section-toggle">
                    <input type="radio" name="class_id" value="{{ $class->id }}" {{ (string) old('class_id') === (string) $class->id ? 'checked' : '' }}>
                    <span>{{ $class->name }}</span>
                </label>
            @endforeach
        </div>
        @error('class_id') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="info-box">
        <i class="fa-solid fa-lightbulb"></i>
        <span>Once registered, the student account is available immediately with the roll number entered above.</span>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.students.index') }}" class="cancel-btn">Cancel</a>
        <button type="submit" class="save-btn"><i class="fa-solid fa-user-plus"></i> Register Student</button>
    </div>
</form>
@endsection
