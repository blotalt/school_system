@extends('layouts.teacher')

@section('content')

@php
$audienceMeta = [
    'everyone' => ['icon' => 'fa-bell',            'color' => 'green', 'tag' => 'everyone', 'label' => 'Everyone'],
    'students' => ['icon' => 'fa-user-graduate',   'color' => 'blue',  'tag' => 'student',  'label' => 'Students'],
    'teachers' => ['icon' => 'fa-users',           'color' => 'red',   'tag' => 'teacher',  'label' => 'Teachers'],
    'class'    => ['icon' => 'fa-clipboard',       'color' => 'navy',  'tag' => 'academic', 'label' => 'Academic'],
];
@endphp

<div class="announcement-page">
    <div class="breadcrumb">
        <span>Portal</span>
        <i class="fa-solid fa-angle-right"></i>
        <span>Announcements</span>
    </div>

    <div class="announcement-header">
        <div>
            <h1>Announcements</h1>
            <p>Stay updated with the latest school news and notices.</p>
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
                <span><i class="fa-regular fa-user"></i> {{ $announcement->author->name ?? 'School' }}</span>
            </div>
            <p>{{ $announcement->body }}</p>
            <div class="announcement-footer">
                <span class="tag {{ $meta['tag'] }}">{{ $meta['label'] }}</span>
                <span class="priority {{ $announcement->priority }}">&#9679; {{ strtoupper($announcement->priority) }} PRIORITY</span>
            </div>
        </div>
    </div>
@empty
    <div class="announcement-card">
        <div class="announcement-content"><p>No announcements yet.</p></div>
    </div>
@endforelse

@endsection
