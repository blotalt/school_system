@extends('layouts.teacher')

@section('content')

<div class="student-profile-page">

    <!-- Page Header -->
    <div class="profile-header">
        <div>
            <h1>My Profile</h1>
            <p>
                Manage your personal information and teacher account.
            </p>
        </div>
    </div>

    <!-- Teacher Profile Card -->
    <div class="student-card">

        <div class="student-left">

            <div class="student-photo">
                <img src="{{ asset('images/avatar.png') }}">
            </div>

            <div class="student-info">

                <h2>Phearun Khun</h2>
            
                <h4>Biology Teacher</h4>

                <div class="student-tags">


                </div>

            </div>

        </div>

        <div class="student-id-card">

            <small>TEACHER ID</small>

            <h3>TCH-2026-001</h3>

        </div>

    </div>

    <!-- Personal Information -->
    <div class="profile-form">

        <div class="form-header">

            <h2>Personal Information</h2>

            <button class="edit-btn">
                Edit Mode
            </button>

        </div>

        <!-- Full Name -->
        <div class="form-group">

            <label>FULL NAME</label>

            <input
                type="text"
                value="Phearun Khun">

        </div>

        <!-- Date of Birth -->
        <div class="form-group">

            <label>DATE OF BIRTH</label>

            <input
                type="text"
                value="May 14, 1998">

        </div>

        <!-- Country -->
        <div class="form-group">

            <label>COUNTRY</label>

            <input
                type="text"
                value="Cambodia">

        </div>

        <!-- Phone -->
        <div class="form-group">

            <label>PHONE NUMBER</label>

            <input
                type="text"
                value="+855 12 345 678">

        </div>

        <!-- Email -->
        <div class="form-group">

            <label>EMAIL ADDRESS</label>

            <input
                type="email"
                value="phearunkhun@email.com">

        </div>

        <!-- Department -->
        <div class="form-group">

            <label>DEPARTMENT</label>

            <input
                type="text"
                value="Science Department">

        </div>

        <!-- Buttons -->
        <div class="profile-actions">

            <button class="discard-btn">
                Discard Changes
            </button>

            <button class="save-btn">
                Save Details
            </button>

        </div>

    </div>

</div>

@endsection