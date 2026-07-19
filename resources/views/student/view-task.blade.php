@extends('layouts.student')

@section('content')

@php $overdue = $homework->due_date && $homework->due_date->isPast(); @endphp

<div class="breadcrumb">
    <a href="{{ route('student.dashboard') }}">Dashboard</a> &gt;
    <a href="{{ route('student.homework.index') }}">Homework</a> &gt;
    <span>{{ $homework->title }}</span>
</div>

<x-page-header>
    <div>
        <h1>{{ $homework->title }}</h1>
        <p>{{ $homework->subject->name ?? '—' }} &middot; {{ $homework->schoolClass->name ?? '—' }}</p>
    </div>
</x-page-header>

<div class="data-card" style="padding:30px;">
    <div class="stat-grid" style="margin-bottom:24px;">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-regular fa-calendar"></i></div>
            <div class="stat-value" style="font-size:18px;">{{ $homework->due_date->format('M j, Y') }}</div>
            <div class="stat-label">Due Date</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-value" style="font-size:18px;">
                <span class="badge {{ $overdue ? 'badge-geography' : 'badge-science' }}">{{ $overdue ? 'Past Due' : 'Upcoming' }}</span>
            </div>
            <div class="stat-label">Status</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-regular fa-user"></i></div>
            <div class="stat-value" style="font-size:18px;">{{ $homework->teacher->user->name ?? '—' }}</div>
            <div class="stat-label">Assigned By</div>
        </div>
    </div>

    <h3 style="margin-bottom:12px;">Description</h3>
    <p style="color:#4b5563;line-height:1.6;">{{ $homework->description ?: 'No additional description provided.' }}</p>

    @if($homework->attachment_path)
        <div style="margin-top:24px;">
            <a href="{{ asset('storage/' . $homework->attachment_path) }}" target="_blank" class="add-btn">
                <i class="fa-solid fa-paperclip"></i> {{ $homework->attachment_name }}
            </a>
        </div>
    @endif
</div>

@endsection
