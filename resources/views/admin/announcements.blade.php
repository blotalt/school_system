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

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="filter-card">
    <span>Audience:</span>
    <a href="{{ route('admin.announcements.index') }}" class="{{ !$audience || $audience === 'all' ? 'active' : '' }}">All</a>
    <a href="{{ route('admin.announcements.index', ['audience' => 'students']) }}" class="{{ $audience === 'students' ? 'active' : '' }}">Students</a>
    <a href="{{ route('admin.announcements.index', ['audience' => 'teachers']) }}" class="{{ $audience === 'teachers' ? 'active' : '' }}">Teachers</a>
</div>

@php
$audienceMeta = [
    'all'      => ['icon' => 'navy',  'iconClass' => 'fa-bullhorn',            'tagLabel' => 'Everyone'],
    'students' => ['icon' => 'green', 'iconClass' => 'fa-circle-check',        'tagLabel' => 'Students'],
    'teachers' => ['icon' => 'red',   'iconClass' => 'fa-triangle-exclamation','tagLabel' => 'Teachers'],
];
@endphp

@forelse($announcements as $announcement)
@php $meta = $audienceMeta[$announcement->audience] ?? $audienceMeta['all']; @endphp
<div class="announcement-card">
    <div class="announcement-icon {{ $meta['icon'] }}">
        <i class="fa-solid {{ $meta['iconClass'] }}"></i>
    </div>
    <div class="announcement-content">
        <div class="announcement-top">
            <h3>{{ $announcement->title }}</h3>
            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                @csrf
                @method('DELETE')
                <button type="submit" title="Delete" style="background:none;border:none;cursor:pointer;color:#9ca3af;">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
        <div class="announcement-info">
            <span><i class="fa-regular fa-calendar"></i> {{ $announcement->created_at->format('F j, Y') }}</span>
            <span><i class="fa-regular fa-user"></i> {{ $announcement->author->name ?? 'Admin Office' }}</span>
        </div>
        <p>{{ $announcement->body }}</p>
        <div class="announcement-footer">
            <span class="tag {{ $announcement->audience }}">{{ $meta['tagLabel'] }}</span>
        </div>
    </div>
</div>
@empty
<p>No announcements yet.</p>
@endforelse

<div class="announcement-pagination">
    {{ $announcements->links() }}
</div>

<!-- New Announcement Modal -->
<div id="newAnnouncementModal" class="slot-modal-overlay" style="display:none;">
    <div class="slot-modal" style="width:480px;">
        <h3>New Announcement</h3>
        <form action="{{ route('admin.announcements.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" placeholder="Announcement title" required>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="body" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;" required></textarea>
            </div>
            <div class="form-group">
                <label>Audience</label>
                <select name="audience">
                    <option value="all">Everyone</option>
                    <option value="students">Students</option>
                    <option value="teachers">Teachers</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="document.getElementById('newAnnouncementModal').style.display='none'">Cancel</button>
                <button type="submit" class="save-btn">Post Announcement</button>
            </div>
        </form>
    </div>
</div>
@endsection
