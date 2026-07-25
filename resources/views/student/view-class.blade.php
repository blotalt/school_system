@extends('layouts.student')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('student.dashboard') }}">{{ __('common.dashboard') }}</a> &gt;
    <span>{{ $schedule->subject?->displayName() ?? __('student.view_class.class_fallback') }}</span>

</div>

<x-page-header>
    <div>
        <h1>{{ $schedule->subject?->displayName() ?? '—' }}</h1>

        <p>{{ $schedule->schoolClass->name ?? '—' }} &middot; {{ __('common.days.' . $schedule->day_of_week) }}, {{ __('student.view_class.period_label', ['period' => $schedule->period]) }}</p>
    </div>
</x-page-header>

<div class="profile-wrapper">
    <div class="profile-left">
        <div class="profile-card">
            <div class="profile-image">
                <div class="avatar-circle" style="width:100px;height:100px;font-size:28px;">
                    {{ collect(explode(' ', $schedule->teacher->user->name ?? '—'))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
                </div>
            </div>
            <h2>{{ $schedule->teacher->user->name ?? __('student.dashboard.unassigned') }}</h2>
            <span class="role-badge">{{ __('common.teacher') }}</span>
            <hr>
            <div class="profile-info">
                <label>{{ __('common.subject') }}</label>
                <h4>{{ $schedule->subject?->displayName() ?? '—' }}</h4>
            </div>
            <div class="profile-info">
                <label>{{ __('common.email') }}</label>
                <h4>{{ $schedule->teacher->user->email ?? '—' }}</h4>
            </div>
        </div>
    </div>

    <div class="profile-right">
        <div class="data-card-header" style="padding:0 0 16px;">
            <h3>{{ __('student.view_class.classmates') }}</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('common.student') }}</th>
                    <th>{{ __('student.view_class.roll_no_column') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classmates as $classmate)
                    <tr>
                        <td>{{ $classmate->user->name }}</td>
                        <td>{{ $classmate->roll_no }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" style="text-align:center;color:#8a94a6;">{{ __('student.view_class.no_classmates_found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
