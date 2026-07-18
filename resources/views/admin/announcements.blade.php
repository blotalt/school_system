@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Announcements</h1>
        <p>Post and manage school-wide announcements.</p>
    </div>
    <button type="button" class="view-btn" onclick="document.getElementById('newAnnouncementModal').style.display='flex'">
        <i class="fa-solid fa-plus"></i> New Announcement
    </button>
</x-page-header>

@if(session('status'))
    <div class="filter-card" style="color:#1a7f37;">{{ session('status') }}</div>
@endif

@php
    $audiences = ['' => 'All', 'everyone' => 'Everyone', 'students' => 'Students', 'teachers' => 'Teachers'];
    $priorityIcon = ['high' => ['red','fa-triangle-exclamation'], 'medium' => ['navy','fa-bullhorn'], 'normal' => ['green','fa-circle-check']];
@endphp

<div class="filter-card">
    <span>Audience:</span>
    @foreach($audiences as $value => $label)
        <a href="{{ route('admin.announcements.index', $value ? ['audience' => $value] : []) }}">
            <button type="button" class="{{ ($filter ?? '') === $value ? 'active' : '' }}">{{ $label }}</button>
        </a>
    @endforeach
</div>

@forelse($announcements as $a)
    @php [$iconColor, $iconClass] = $priorityIcon[$a->priority] ?? ['navy','fa-bullhorn']; @endphp
    <div class="announcement-card">
        <div class="announcement-icon {{ $iconColor }}">
            <i class="fa-solid {{ $iconClass }}"></i>
        </div>
        <div class="announcement-content">
            <div class="announcement-top">
                <h3>{{ $a->title }}</h3>
                <i class="fa-solid fa-ellipsis"></i>
            </div>
            <div class="announcement-info">
                <span><i class="fa-regular fa-calendar"></i> {{ $a->created_at->format('M d, Y') }}</span>
                <span><i class="fa-regular fa-user"></i> {{ $a->author->name ?? 'School' }}</span>
            </div>
            <p>{{ $a->body }}</p>
            <div class="announcement-footer">
                <span class="tag {{ $a->audience }}">
                    {{ $a->audience === 'class' ? ($a->schoolClass->name ?? 'Class') : ucfirst($a->audience) }}
                </span>
                <span class="priority {{ $a->priority }}">{{ ucfirst($a->priority) }}{{ $a->priority !== 'normal' ? ' Priority' : '' }}</span>
            </div>
        </div>
    </div>
@empty
    <div class="filter-card" style="color:#8a94a6;">No announcements yet.</div>
@endforelse

<!-- New Announcement Modal -->
<div id="newAnnouncementModal" class="slot-modal-overlay" style="display:{{ $errors->any() ? 'flex' : 'none' }};">
    <form class="slot-modal" style="width:480px;" method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf
        <h3>New Announcement</h3>

        @if($errors->any())
            <div class="form-group" style="color:#c0392b;">Please fix the errors below.</div>
        @endif

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Announcement title">
            @error('title') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea name="body" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;">{{ old('body') }}</textarea>
            @error('body') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Audience</label>
            <select name="audience">
                <option value="everyone" @selected(old('audience')==='everyone')>Everyone</option>
                <option value="students" @selected(old('audience')==='students')>Students</option>
                <option value="teachers" @selected(old('audience')==='teachers')>Teachers</option>
                <option value="class" @selected(old('audience')==='class')>Specific Class</option>
            </select>
            @error('audience') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Class (only if audience is Specific Class)</label>
            <select name="class_id">
                <option value="">—</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected((string) old('class_id') === (string) $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Priority</label>
            <select name="priority">
                <option value="normal" @selected(old('priority','normal')==='normal')>Normal</option>
                <option value="medium" @selected(old('priority')==='medium')>Medium</option>
                <option value="high" @selected(old('priority')==='high')>High</option>
            </select>
            @error('priority') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('newAnnouncementModal').style.display='none'">Cancel</button>
            <button type="submit" class="save-btn">Post Announcement</button>
        </div>
    </form>
</div>
@endsection
