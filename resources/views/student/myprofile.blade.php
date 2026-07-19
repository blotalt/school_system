@extends('layouts.student')

@section('content')

<div class="student-profile-page">

    <!-- Page Header -->

    <div class="profile-header">

        <div>

            <h1>My Profile</h1>

            <p>
                Manage your personal information and learning account.
            </p>

        </div>

    </div>

    <!-- Student Profile Card -->

<div class="student-card">

    <div class="student-left">

        <div class="student-photo">

            <img src="{{ asset('images/student.png') }}" >
       

        </div>

        <div class="student-info">

            <h2>Bruno Mars</h2>

            <h4>Science Track Specialist</h4>

            <div class="student-tags">

                <span>Grade 12</span>

                <span>Section A</span>

                <span>Class of 2024</span>

            </div>

        </div>

    </div>

    <div class="student-id-card">

        <small>STUDENT ID</small>

        <h3>CHS-2024-0892</h3>

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
            value="Bruno Mars">

    </div>

    <!-- Date of Birth -->

    <div class="form-group">

        <label>DATE OF BIRTH</label>

        <input
            type="text"
            value="May 14, 2004">

    </div>

    <!-- Country -->

    <div class="form-group">

        <label>COUNTRY</label>

        <input
            type="text"
            value="United States">

    </div>

    <!-- Phone -->

    <div class="form-group">

        <label>PHONE NUMBER</label>

        <input
            type="text"
            value="+1 (855) 012-3456">

    </div>

    <!-- Learning Goal -->


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