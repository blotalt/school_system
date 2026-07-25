@extends('layouts.teacher')

@section('content')
<div class="profile-page">
    <div class="profile-header" style="display:flex;justify-content:space-between;align-items:flex-start;">
        <div>
            <h1>{{ __('common.my_profile') }}</h1>
            <p>{{ __('teacher.profile.subtitle') }}</p>
        </div>
        <x-language-switcher />
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-wrapper">
        <div class="profile-left">
            <div class="profile-card">
                <div class="profile-image">
                    <div class="avatar-circle" style="width:100px;height:100px;font-size:28px;">
                        {{ collect(explode(' ', $user->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                    </div>
                    <button type="button" class="camera-btn" title="Photo upload coming soon"><i class="fa-solid fa-camera"></i></button>
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
            <div class="profile-form-header">
                <h2>{{ __('teacher.profile.teaching_info') }}</h2>
            </div>

            <div class="account-card" style="margin-top:0;">
                <div class="profile-info">
                    <label>{{ __('common.subject') }}</label>
                    <h4>{{ $teacher?->subjects->map->displayName()->implode(', ') ?: '—' }}</h4>
                </div>
                <div class="profile-info">
                    <label>{{ __('common.assigned_classes') }}</label>
                    <h4>{{ $teacher?->classes->map->displayName()->implode(', ') ?: '—' }}</h4>
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