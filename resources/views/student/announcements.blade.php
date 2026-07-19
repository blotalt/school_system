@extends('layouts.student')

@section('content')

@php
$audienceMeta = [
    'everyone'  => ['class' => 'general',  'label' => 'Everyone',   'icon' => 'fa-bullhorn'],
    'students'  => ['class' => 'events',   'label' => 'Students',   'icon' => 'fa-user-graduate'],
    'teachers'  => ['class' => 'academic', 'label' => 'Teachers',   'icon' => 'fa-chalkboard-user'],
    'class'     => ['class' => 'academic', 'label' => 'Your Class', 'icon' => 'fa-school'],
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
                <h1>Hello, {{ auth()->user()->name }}</h1>
            </div>
        </div>
        <div class="student-date">
            <small>CURRENT DATE</small>
            <h2>{{ now()->format('F j, Y') }}</h2>
        </div>
    </div>

    <div class="announcement-top">
        <div>
            <p class="breadcrumb">System &gt; <strong>Announcements</strong></p>
            <h2>Announcements</h2>
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
                    <span><i class="fa-regular fa-user"></i> {{ $announcement->author->name ?? 'School' }}</span>
                </div>
                <p>{{ $announcement->body }}</p>
            </div>
        </div>
    @empty
        <div class="announcement-card">
            <div class="announcement-content">
                <p>No announcements yet.</p>
            </div>
        </div>
    @endforelse
</div>

@endsection
