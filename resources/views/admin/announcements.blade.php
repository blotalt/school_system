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
            </div>
            <div class="announcement-info">
                <span><i class="fa-regular fa-calendar"></i> {{ $a->created_at->format('M d, Y') }}</span>
                <span><i class="fa-regular fa-user"></i> {{ $a->author->name ?? 'School' }}</span>
            </div>
            <p>{!! $a->body !!}</p>
            <div class="announcement-footer">
                <span class="tag {{ $a->audience }}">
                    {{ $a->audience === 'class' ? ($a->schoolClass->name ?? 'Class') : ucfirst($a->audience) }}
                </span>
                <span class="priority {{ $a->priority }}">{{ ucfirst($a->priority) }}{{ $a->priority !== 'normal' ? ' Priority' : '' }}</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;margin-left:auto;padding-left:16px;flex-shrink:0;">
            <a href="#" onclick="openEditModal({{ $a->id }}, '{{ addslashes($a->title) }}', {{ json_encode($a->body) }}, '{{ $a->audience }}', '{{ $a->class_id }}', '{{ $a->priority }}')"
               style="width:32px;height:32px;border-radius:8px;background:#eef1f6;display:flex;align-items:center;justify-content:center;color:#374151;">
                <i class="fa-solid fa-pen" style="font-size:13px;"></i>
            </a>
            <a href="#" onclick="openDeleteModal({{ $a->id }}, '{{ addslashes($a->title) }}')"
               style="width:32px;height:32px;border-radius:8px;background:#fef2f2;display:flex;align-items:center;justify-content:center;color:#ef4444;">
                <i class="fa-solid fa-trash" style="font-size:13px;"></i>
            </a>
        </div>
    </div>
@empty
    <div class="filter-card" style="color:#8a94a6;">No announcements yet.</div>
@endforelse

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div id="newAnnouncementModal" class="slot-modal-overlay" style="display:{{ $errors->any() ? 'flex' : 'none' }};">
    <form class="slot-modal" style="width:640px;max-height:90vh;overflow-y:auto;" method="POST" action="{{ route('admin.announcements.store') }}">
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
            <div id="body-editor" style="height:200px;border-radius:10px;"></div>
            <input type="hidden" name="body" id="body" value="{{ old('body') }}">
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
            <button type="submit" class="save-btn" id="submitBtn">Post Announcement</button>
        </div>
    </form>
</div>

<div id="editAnnouncementModal" class="slot-modal-overlay" style="display:none;">
    <form class="slot-modal" style="width:640px;max-height:90vh;overflow-y:auto;" method="POST" id="editForm">
        @csrf
        @method('PUT')
        <h3>Edit Announcement</h3>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" id="editTitle" placeholder="Announcement title">
        </div>

        <div class="form-group">
            <label>Message</label>
            <div id="edit-body-editor" style="height:200px;border-radius:10px;"></div>
            <input type="hidden" name="body" id="editBody">
        </div>

        <div class="form-group">
            <label>Audience</label>
            <select name="audience" id="editAudience">
                <option value="everyone">Everyone</option>
                <option value="students">Students</option>
                <option value="teachers">Teachers</option>
                <option value="class">Specific Class</option>
            </select>
        </div>

        <div class="form-group">
            <label>Class (only if audience is Specific Class)</label>
            <select name="class_id" id="editClassId">
                <option value="">—</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Priority</label>
            <select name="priority" id="editPriority">
                <option value="normal">Normal</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('editAnnouncementModal').style.display='none'">Cancel</button>
            <button type="submit" class="save-btn" id="editSubmitBtn">Save Changes</button>
        </div>
    </form>
</div>

<div id="deleteAnnouncementModal" class="slot-modal-overlay" style="display:none;">
    <div class="slot-modal" style="width:400px;text-align:center;">
        <div style="width:56px;height:56px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i class="fa-solid fa-trash" style="color:#ef4444;font-size:22px;"></i>
        </div>
        <h3 style="margin-bottom:8px;">Delete Announcement</h3>
        <p id="deleteModalText" style="color:#6b7280;margin-bottom:24px;"></p>
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="form-actions" style="justify-content:center;">
                <button type="button" class="cancel-btn" onclick="document.getElementById('deleteAnnouncementModal').style.display='none'">Cancel</button>
                <button type="submit" class="save-btn" style="background:#ef4444;">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
var quill = new Quill('#body-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['link'], ['clean']
        ]
    }
});

var oldVal = document.getElementById('body').value;
if (oldVal) quill.root.innerHTML = oldVal;

document.getElementById('submitBtn').addEventListener('click', function() {
    var content = quill.root.innerHTML;
    if (content === '<p><br></p>') content = '';
    document.getElementById('body').value = content;
});

var editQuill = new Quill('#edit-body-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['link'], ['clean']
        ]
    }
});

function openEditModal(id, title, body, audience, classId, priority) {
    document.getElementById('editForm').action = '/admin/announcements/' + id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editAudience').value = audience;
    document.getElementById('editClassId').value = classId || '';
    document.getElementById('editPriority').value = priority;
    editQuill.root.innerHTML = body;
    document.getElementById('editAnnouncementModal').style.display = 'flex';
}

document.getElementById('editSubmitBtn').addEventListener('click', function() {
    var content = editQuill.root.innerHTML;
    if (content === '<p><br></p>') content = '';
    document.getElementById('editBody').value = content;
});

function openDeleteModal(id, title) {
    document.getElementById('deleteForm').action = '/admin/announcements/' + id;
    document.getElementById('deleteModalText').textContent = 'Are you sure you want to delete "' + title + '"? This cannot be undone.';
    document.getElementById('deleteAnnouncementModal').style.display = 'flex';
}
</script>
@endsection