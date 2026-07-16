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

<div class="filter-card">
    <span>Audience:</span>
    <button type="button" class="active">All</button>
    <button type="button">Students</button>
    <button type="button">Teachers</button>
    <button type="button">Everyone</button>
</div>

@php
$announcements = [
    (object)['icon'=>'navy','iconClass'=>'fa-bullhorn','title'=>'Mid-Term Exam Schedule Released','date'=>'July 12, 2026','author'=>'Admin Office','body'=>'The mid-term examination schedule for all grades has been published. Please check the Exams section for your specific timetable.','tag'=>'academic','tagLabel'=>'Academic','priority'=>'high','priorityLabel'=>'High Priority'],
    (object)['icon'=>'green','iconClass'=>'fa-circle-check','title'=>'School Closed for Public Holiday','date'=>'July 10, 2026','author'=>'Admin Office','body'=>'The school will be closed on July 18th in observance of the public holiday. Classes will resume as normal the following day.','tag'=>'everyone','tagLabel'=>'Everyone','priority'=>'normal','priorityLabel'=>'Normal'],
    (object)['icon'=>'red','iconClass'=>'fa-triangle-exclamation','title'=>'Staff Meeting - Mandatory Attendance','date'=>'July 8, 2026','author'=>'Admin Office','body'=>'All teaching staff are required to attend the quarterly review meeting this Friday at 3:30 PM in Conference Room A.','tag'=>'teacher','tagLabel'=>'Teachers','priority'=>'medium','priorityLabel'=>'Medium Priority'],
];
@endphp

@foreach($announcements as $a)
<div class="announcement-card">
    <div class="announcement-icon {{ $a->icon }}">
        <i class="fa-solid {{ $a->iconClass }}"></i>
    </div>
    <div class="announcement-content">
        <div class="announcement-top">
            <h3>{{ $a->title }}</h3>
            <i class="fa-solid fa-ellipsis"></i>
        </div>
        <div class="announcement-info">
            <span><i class="fa-regular fa-calendar"></i> {{ $a->date }}</span>
            <span><i class="fa-regular fa-user"></i> {{ $a->author }}</span>
        </div>
        <p>{{ $a->body }}</p>
        <div class="announcement-footer">
            <span class="tag {{ $a->tag }}">{{ $a->tagLabel }}</span>
            <span class="priority {{ $a->priority }}">{{ $a->priorityLabel }}</span>
        </div>
    </div>
</div>
@endforeach

<div class="announcement-pagination">
    <div class="page-number">
        <button class="number active">1</button>
        <button class="number">2</button>
        <button class="number">3</button>
    </div>
    <button class="page-btn">Next <i class="fa-solid fa-arrow-right"></i></button>
</div>

<!-- New Announcement Modal -->
<div id="newAnnouncementModal" class="slot-modal-overlay" style="display:none;">
    <div class="slot-modal" style="width:480px;">
        <h3>New Announcement</h3>
        <div class="form-group">
            <label>Title</label>
            <input type="text" placeholder="Announcement title">
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;"></textarea>
        </div>
        <div class="form-group">
            <label>Audience</label>
            <select>
                <option>Everyone</option>
                <option>Students</option>
                <option>Teachers</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('newAnnouncementModal').style.display='none'">Cancel</button>
            <button type="button" class="save-btn">Post Announcement</button>
        </div>
    </div>
</div>
@endsection