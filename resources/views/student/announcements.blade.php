@extends('layouts.student')

@section('content')

@php
$audienceMeta = [
    'everyone'  => ['class' => 'general',  'label' => __('student.announcements.audience_everyone'),   'icon' => 'fa-bullhorn'],
    'students'  => ['class' => 'events',   'label' => __('student.announcements.audience_students'),   'icon' => 'fa-user-graduate'],
    'teachers'  => ['class' => 'academic', 'label' => __('student.announcements.audience_teachers'),   'icon' => 'fa-chalkboard-user'],
    'class'     => ['class' => 'academic', 'label' => __('student.announcements.audience_your_class'), 'icon' => 'fa-school'],
];
$priorityMeta = [
    'high'   => 'high',
    'medium' => 'info',
    'normal' => 'normal',
];
@endphp

<div class="student-announcement-page">
    <div class="student-banner">
        <div class="student-left">
            <div class="avatar-circle" style="width:56px;height:56px;">
                {{ collect(explode(' ', auth()->user()->name))->map(fn ($n) => mb_substr($n, 0, 1))->take(2)->implode('') }}
            </div>
            <div>
                <h1>{{ __('student.announcements.hello', ['name' => auth()->user()->name]) }}</h1>
            </div>
        </div>
        <div class="student-date">
            <small>{{ __('student.announcements.current_date') }}</small>
            <h2>{{ now()->format('F j, Y') }}</h2>
        </div>
    </div>

    <div class="announcement-top">
        <div>
            <p class="breadcrumb">{{ __('student.announcements.breadcrumb_system') }} &gt; <strong>{{ __('student.announcements.title') }}</strong></p>
            <h2>{{ __('student.announcements.title') }}</h2>
        </div>
    </div>

    @forelse($announcements as $announcement)
        @php $meta = $audienceMeta[$announcement->audience] ?? $audienceMeta['everyone']; @endphp
        <div class="announcement-card">
            <div class="announcement-icon">
                <i class="fa-solid {{ $meta['icon'] }}"></i>
            </div>
            <div class="announcement-content">
                <div class="announcement-title">
                    <h3>{{ $announcement->title }}</h3>
                    <span class="tag {{ $meta['class'] }}">{{ strtoupper($meta['label']) }}</span>
                    <span class="priority {{ $priorityMeta[$announcement->priority] ?? 'normal' }}">{{ strtoupper($announcement->priority) }}</span>
                </div>
                <div class="announcement-meta">
                    <span><i class="fa-regular fa-calendar"></i> {{ $announcement->created_at->format('M j, Y') }}</span>
                    <span><i class="fa-regular fa-user"></i> {{ $announcement->author->name ?? __('student.announcements.school_fallback') }}</span>
                </div>
                <p>{{ $announcement->body }}</p>
            </div>
        </div>
    @empty
        <div class="announcement-card">
            <div class="announcement-content">
                <p>{{ __('student.announcements.no_announcements_yet') }}</p>
            </div>
        </div>
    @endforelse
</div>

@endsection
