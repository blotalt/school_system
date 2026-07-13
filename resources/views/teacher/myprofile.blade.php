@extends('layouts.teacher')

@section('content')

<div class="profile-page">

    <!-- Header -->
    <div class="profile-header">
        <div>
            <h1>My Profile</h1>
            <p>Manage your personal information and learning account.</p>
        </div>
    </div>

    <!-- Two Columns -->
    <div class="profile-wrapper">

        <!-- LEFT SIDE -->
        <div class="profile-left">

            <!-- Teacher Profile Card -->
            <div class="profile-card">

                <div class="profile-image">
                    <img src="{{ asset('images/avatar.png') }}" alt="Teacher">

                    <button class="camera-btn">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                </div>

                <h2>Phearun Khun</h2>

                <span class="role-badge">
                    Teacher
                </span>

                <hr>

                <div class="profile-info">

                    <div>
                        <label>STUDENT ID</label>
                        <h5>ENG2026001</h5>
                    </div>

                    <div>
                        <label>JOIN DATE</label>
                        <h5>January 2026</h5>
                    </div>

                </div>

                <div class="email-box">

                    <label>EMAIL ADDRESS</label>

                    <h5>phearunkhun@email.com</h5>

                </div>

            </div>

            <!-- Account Settings -->
            <div class="account-card">

                <h3>Account Settings</h3>

                <div class="setting-item">

                    <div class="setting-left">
                        <i class="fa-solid fa-pen"></i>
                        <span>Edit Profile Details</span>
                    </div>

                    <i class="fa-solid fa-angle-right"></i>

                </div>

                <div class="setting-item">

                    <div class="setting-left">
                        <i class="fa-solid fa-lock"></i>
                        <span>Change Password</span>
                    </div>

                    <i class="fa-solid fa-angle-right"></i>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="profile-right">

            <div class="profile-form-header">

                <h2>Personal Information</h2>

                <button class="edit-btn">
                    Edit Mode
                </button>

            </div>

            <div class="form-group">
                <label>FULL NAME</label>
                <input type="text" value="Phearun Khun">
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label>DATE OF BIRTH</label>
                    <input type="text" value="May 14, 1998">
                </div>

                <div class="form-group">
                    <label>COUNTRY</label>
                    <input type="text" value="Cambodia">
                </div>

            </div>

            <div class="form-group">
                <label>PHONE NUMBER</label>
                <input type="text" value="+1 (855) 012-3456">
            </div>

            <div class="form-group">
                <label>LEARNING GOAL</label>

                <textarea rows="5">Mastering academic writing for university level, focusing on complex grammar structures and high-level vocabulary expansion in formal contexts.</textarea>

            </div>
            <!-- ================= Action Buttons ================= -->

<div class="profile-actions">

    <button class="discard-profile-btn">
        <i class="fa-solid fa-xmark"></i>
        Discard Changes
    </button>

    <button class="save-profile-btn">
        <i class="fa-solid fa-floppy-disk"></i>
        Save Details
    </button>

</div>

        </div>

    </div>

</div>

@endsection