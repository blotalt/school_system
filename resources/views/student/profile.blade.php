@extends('layouts.student')

@section('content')
<div class="profile-page">
    <div class="profile-header">
        <h1>{{ __('common.my_profile') }}</h1>
        <p>{{ __('student.profile.subtitle') }}</p>
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
                <span class="role-badge">{{ __('student.profile.role_student') }}</span>
                <hr>
                <div class="profile-info">
                    <label>{{ __('common.email') }}</label>
                    <h4>{{ $user->email }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.roll_number') }}</label>
                    <h4>{{ $student?->roll_no ?? '—' }}</h4>
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="account-card">
                <h3>{{ __('student.profile.enrollment_details') }}</h3>
                <div class="profile-info">
                    <label>{{ __('common.class') }}</label>
                    <h4>{{ $student?->schoolClass?->name ?? '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.track') }}</label>
                    <h4>{{ $student?->schoolClass?->track ?? '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.guardian_contact') }}</label>
                    <h4>{{ $student?->guardian_contact ?? '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.date_of_birth') }}</label>
                    <h4>{{ $student?->date_of_birth?->format('F j, Y') ?? '—' }}</h4>
                </div>
                <p style="color:#9ca3af;font-size:13px;margin-top:16px;">
                    <i class="fa-solid fa-circle-info"></i> {{ __('student.profile.contact_admin_notice') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
