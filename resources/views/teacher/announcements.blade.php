@extends('layouts.teacher')

@section('content')
<div class="page-title">
<h1>Announcements</h1>
        <p>School-wide notices visible to teaching staff.</p>
</div>

@php
    $priorityIcon = [
        'high'   => ['red',   'fa-triangle-exclamation'],
        'medium' => ['navy',  'fa-bullhorn'],
        'normal' => ['green', 'fa-circle-check'],
    ];
@endphp

@forelse($announcements as $a)
    @php [$iconColor, $iconClass] = $priorityIcon[$a->priority] ?? ['navy', 'fa-bullhorn']; @endphp
    <div class="announcement-card">
        <div class="announcement-icon {{ $iconColor }}">
            <i class="fa-solid {{ $iconClass }}"></i>
        </div>
        <div class="announcement-content">
            <div class="announcement-top">
                <h3>{{ $a->title }}</h3>
            </div>
            <div class="announcement-info">
                <span><i class="fa-regular fa-calendar"></i> {{ $a->created_at->format('M d, Y') }}</span>
                <span><i class="fa-regular fa-user"></i> {{ $a->author->name ?? 'School' }}</span>
            </div>
            <p>{{ $a->body }}</p>
            <div class="announcement-footer">
                <span class="tag {{ $a->audience }}">{{ ucfirst($a->audience) }}</span>
                <span class="priority {{ $a->priority }}">{{ ucfirst($a->priority) }}{{ $a->priority !== 'normal' ? ' Priority' : '' }}</span>
            </div>
        </div>
    </div>
@empty
    <div class="filter-card" style="color:#8a94a6;">No announcements yet.</div>
@endforelse
@endsection
