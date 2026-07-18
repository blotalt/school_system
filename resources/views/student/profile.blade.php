@extends('layouts.student')

@section('content')
<div class="profile-page">
    <div class="profile-header">
        <h1>My Profile</h1>
        <p>Your account information.</p>
    </div>

    <div class="profile-wrapper">
        <div class="profile-left">
            <div class="profile-card">
                <div class="profile-image">
                    <div class="avatar-circle" style="width:100px;height:100px;font-size:28px;">
                        {{ collect(explode(' ', $user->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                    </div>
                </div>
                <h2>{{ $user->name }}</h2>
                <span class="role-badge">Student</span>
                <hr>
                <div class="profile-info">
                    <label>Email</label>
                    <h4>{{ $user->email }}</h4>
                </div>
                <div class="profile-info">
                    <label>Roll Number</label>
                    <h4>{{ $student?->roll_no ?? '—' }}</h4>
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="account-card">
                <h3>Enrollment Details</h3>
                <div class="profile-info">
                    <label>Class</label>
                    <h4>{{ $student?->schoolClass?->name ?? '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>Track</label>
                    <h4>{{ $student?->schoolClass?->track ?? '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>Guardian Contact</label>
                    <h4>{{ $student?->guardian_contact ?? '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>Date of Birth</label>
                    <h4>{{ $student?->date_of_birth?->format('F j, Y') ?? '—' }}</h4>
                </div>
                <p style="color:#9ca3af;font-size:13px;margin-top:16px;">
                    <i class="fa-solid fa-circle-info"></i> Contact your school administrator to update this information.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
