@extends('layouts.teacher')

@section('content')
<div class="profile-page">
    <div class="profile-header">
        <h1>{{ __('common.my_profile') }}</h1>
        <p>{{ __('teacher.profile.subtitle') }}</p>
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
                <span class="role-badge">{{ __('teacher.profile.role_teacher') }}</span>
                <hr>
                <div class="profile-info">
                    <label>{{ __('common.email') }}</label>
                    <h4>{{ $user->email }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.member_since') }}</label>
                    <h4>{{ $user->created_at->format('F Y') }}</h4>
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="account-card">
                <h3>{{ __('teacher.profile.teaching_info') }}</h3>
                <div class="profile-info">
                    <label>{{ __('common.subjects') }}</label>
                    <h4>{{ $teacher?->subjects->pluck('name')->implode(', ') ?: '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.assigned_classes') }}</label>
                    <h4>{{ $teacher?->classes->pluck('name')->implode(', ') ?: '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('teacher.profile.phone') }}</label>
                    <h4>{{ $teacher?->phone ?? '—' }}</h4>
                </div>
                <p style="color:#9ca3af;font-size:13px;margin-top:16px;">
                    <i class="fa-solid fa-circle-info"></i> {{ __('teacher.profile.contact_admin_notice') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
