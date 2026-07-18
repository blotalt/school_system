@extends('layouts.teacher')

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
                <span class="role-badge">Teacher</span>
                <hr>
                <div class="profile-info">
                    <label>Email</label>
                    <h4>{{ $user->email }}</h4>
                </div>
                <div class="profile-info">
                    <label>Member Since</label>
                    <h4>{{ $user->created_at->format('F Y') }}</h4>
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="account-card">
                <h3>Teaching Info</h3>
                <div class="profile-info">
                    <label>Subjects</label>
                    <h4>{{ $teacher?->subjects->pluck('name')->implode(', ') ?: '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>Assigned Classes</label>
                    <h4>{{ $teacher?->classes->pluck('name')->implode(', ') ?: '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>Phone</label>
                    <h4>{{ $teacher?->phone ?? '—' }}</h4>
                </div>
                <p style="color:#9ca3af;font-size:13px;margin-top:16px;">
                    <i class="fa-solid fa-circle-info"></i> Contact your school administrator to update this information.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
