@extends('layouts.teacher')

@section('content')

@php
$audienceMeta = [
    'everyone' => ['icon' => 'fa-bell',            'color' => 'green', 'tag' => 'everyone', 'label' => __('teacher.announcements.audience_everyone')],
    'students' => ['icon' => 'fa-user-graduate',   'color' => 'blue',  'tag' => 'student',  'label' => __('teacher.announcements.audience_students')],
    'teachers' => ['icon' => 'fa-users',           'color' => 'red',   'tag' => 'teacher',  'label' => __('teacher.announcements.audience_teachers')],
    'class'    => ['icon' => 'fa-clipboard',       'color' => 'navy',  'tag' => 'academic', 'label' => __('teacher.announcements.audience_academic')],
];
@endphp

<div class="announcement-page">
    <div class="breadcrumb">
        <span>{{ __('teacher.announcements.breadcrumb_portal') }}</span>
        <i class="fa-solid fa-angle-right"></i>
        <span>{{ __('teacher.announcements.title') }}</span>
    </div>

    <div class="announcement-header">
        <div>
            <h1>{{ __('teacher.announcements.title') }}</h1>
            <p>{{ __('teacher.announcements.subtitle') }}</p>
        </div>
    </div>
</div>

@forelse($announcements as $announcement)
    @php $meta = $audienceMeta[$announcement->audience] ?? $audienceMeta['everyone']; @endphp
    <div class="announcement-card">
        <div class="announcement-icon {{ $meta['color'] }}">
            <i class="fa-solid {{ $meta['icon'] }}"></i>
        </div>
        <div class="announcement-content">
            <div class="announcement-top">
                <h3>{{ $announcement->title }}</h3>
            </div>
            <div class="announcement-info">
                <span><i class="fa-regular fa-calendar"></i> {{ $announcement->created_at->format('M j, Y') }}</span>
                <span><i class="fa-regular fa-user"></i> {{ $announcement->author->name ?? __('teacher.announcements.school_fallback') }}</span>
            </div>
            <p>{{ $announcement->body }}</p>
            <div class="announcement-footer">
                <span class="tag {{ $meta['tag'] }}">{{ $meta['label'] }}</span>
                <span class="priority {{ $announcement->priority }}">&#9679; {{ strtoupper($announcement->priority) }} {{ __('teacher.announcements.priority_suffix') }}</span>
            </div>
        </div>
    </div>
@empty
    <div class="announcement-card">
        <div class="announcement-content"><p>{{ __('teacher.announcements.no_announcements_yet') }}</p></div>
    </div>
@endforelse

@endsection
