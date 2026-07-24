@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.announcements.title') }}</h1>
        <p>{{ __('admin.announcements.subtitle') }}</p>
    </div>
    <button type="button" class="view-btn" onclick="openCreateAnnouncementModal()">
        <i class="fa-solid fa-plus"></i> {{ __('admin.announcements.new_announcement') }}
    </button>
</x-page-header>

@if(session('status'))
    <div class="filter-card" style="color:#1a7f37;">{{ session('status') }}</div>
@endif

@php
    $audiences = ['' => __('admin.announcements.audience_all'), 'everyone' => __('admin.announcements.audience_everyone'), 'students' => __('admin.announcements.audience_students'), 'teachers' => __('admin.announcements.audience_teachers')];
    $priorityIcon = ['high' => ['red','fa-triangle-exclamation'], 'medium' => ['navy','fa-bullhorn'], 'normal' => ['green','fa-circle-check']];
@endphp

<div class="filter-card">
    <span>{{ __('admin.announcements.audience') }}</span>
    @foreach($audiences as $value => $label)
        <a href="{{ route('admin.announcements.index', $value ? ['audience' => $value] : []) }}">
            <button type="button" class="{{ ($filter ?? '') === $value ? 'active' : '' }}">{{ $label }}</button>
        </a>
    @endforeach
</div>

@php
    $priorityLabels = [
        'normal' => __('admin.announcements.priority_normal'),
        'medium' => __('admin.announcements.priority_medium'),
        'high'   => __('admin.announcements.priority_high'),
    ];
@endphp

@forelse($announcements as $a)
    @php [$iconColor, $iconClass] = $priorityIcon[$a->priority] ?? ['navy','fa-bullhorn']; @endphp
    <div class="announcement-card"
        data-id="{{ $a->id }}"
        data-title="{{ $a->title }}"
        data-body="{{ $a->body }}"
        data-audience="{{ $a->audience }}"
        data-class-id="{{ $a->class_id }}"
        data-priority="{{ $a->priority }}"
        data-update-url="{{ route('admin.announcements.update', $a) }}">
        <div class="announcement-icon {{ $iconColor }}">
            <i class="fa-solid {{ $iconClass }}"></i>
        </div>
        <div class="announcement-content">
            <div class="announcement-top">
                <h3>{{ $a->title }}</h3>
                <div class="announcement-menu">
                    <button type="button" class="announcement-menu-btn" onclick="toggleAnnouncementMenu(event, this)">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="announcement-dropdown">
                        <button type="button" class="dropdown-edit" onclick="openEditAnnouncementModal(this)">
                            <i class="fa-solid fa-pen"></i> {{ __('common.edit') }}
                        </button>
                        <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST" onsubmit="return confirm('{{ __('admin.announcements.delete_confirm') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-delete"><i class="fa-solid fa-trash"></i> {{ __('common.delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="announcement-info">
                <span><i class="fa-regular fa-calendar"></i> {{ $a->created_at->format('M d, Y') }}</span>
                <span><i class="fa-regular fa-user"></i> {{ $a->author->name ?? __('admin.announcements.school_fallback') }}</span>
            </div>
            <p>{{ $a->body }}</p>
            <div class="announcement-footer">
                <span class="tag {{ $a->audience }}">
                    {{ $a->audience === 'class' ? ($a->schoolClass->name ?? __('admin.announcements.audience_class_fallback')) : ($audiences[$a->audience] ?? ucfirst($a->audience)) }}
                </span>
                <span class="priority {{ $a->priority }}">{{ $priorityLabels[$a->priority] ?? ucfirst($a->priority) }}{{ $a->priority !== 'normal' ? ' ' . __('admin.announcements.priority_suffix') : '' }}</span>
            </div>
        </div>
    </div>
@empty
    <div class="filter-card" style="color:#8a94a6;">{{ __('admin.announcements.no_announcements_yet') }}</div>
@endforelse

@php
    $editingAnnouncement = old('_editing_id') ? $announcements->firstWhere('id', (int) old('_editing_id')) : null;
@endphp

<!-- New / Edit Announcement Modal -->
<div id="newAnnouncementModal" class="slot-modal-overlay" style="display:{{ $errors->any() ? 'flex' : 'none' }};">
    <form class="slot-modal" style="width:480px;" method="POST" id="announcementForm"
        action="{{ $editingAnnouncement ? route('admin.announcements.update', $editingAnnouncement) : route('admin.announcements.store') }}">
        @csrf
        @if($editingAnnouncement)
            @method('PUT')
        @endif
        <input type="hidden" name="_editing_id" id="modalEditingId" value="{{ old('_editing_id', $editingAnnouncement->id ?? '') }}">
        <h3 id="modalTitleHeading">{{ $editingAnnouncement ? __('admin.announcements.edit_announcement') : __('admin.announcements.new_announcement') }}</h3>

        @if($errors->any())
            <div class="form-group" style="color:#c0392b;">{{ __('admin.announcements.fix_errors') }}</div>
        @endif

        <div class="form-group">
            <label>{{ __('admin.announcements.form_title') }}</label>
            <input type="text" name="title" id="modalTitleInput" value="{{ old('title', $editingAnnouncement->title ?? '') }}" placeholder="{{ __('admin.announcements.title_placeholder') }}">
            @error('title') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('admin.announcements.message') }}</label>
            <textarea name="body" id="modalBodyInput" rows="4" style="width:100%;border:1px solid #e5e9f2;border-radius:10px;padding:12px;">{{ old('body', $editingAnnouncement->body ?? '') }}</textarea>
            @error('body') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('admin.announcements.audience_label') }}</label>
            <select name="audience" id="modalAudienceSelect">
                <option value="everyone" @selected(old('audience', $editingAnnouncement->audience ?? '')==='everyone')>{{ __('admin.announcements.audience_everyone') }}</option>
                <option value="students" @selected(old('audience', $editingAnnouncement->audience ?? '')==='students')>{{ __('admin.announcements.audience_students') }}</option>
                <option value="teachers" @selected(old('audience', $editingAnnouncement->audience ?? '')==='teachers')>{{ __('admin.announcements.audience_teachers') }}</option>
                <option value="class" @selected(old('audience', $editingAnnouncement->audience ?? '')==='class')>{{ __('admin.announcements.audience_specific_class') }}</option>
            </select>
            @error('audience') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('admin.announcements.class_specific_hint') }}</label>
            <select name="class_id" id="modalClassSelect">
                <option value="">—</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected((string) old('class_id', $editingAnnouncement->class_id ?? '') === (string) $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>{{ __('admin.announcements.priority') }}</label>
            <select name="priority" id="modalPrioritySelect">
                <option value="normal" @selected(old('priority', $editingAnnouncement->priority ?? 'normal')==='normal')>{{ __('admin.announcements.priority_normal') }}</option>
                <option value="medium" @selected(old('priority', $editingAnnouncement->priority ?? '')==='medium')>{{ __('admin.announcements.priority_medium') }}</option>
                <option value="high" @selected(old('priority', $editingAnnouncement->priority ?? '')==='high')>{{ __('admin.announcements.priority_high') }}</option>
            </select>
            @error('priority') <span style="color:#c0392b;">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="document.getElementById('newAnnouncementModal').style.display='none'">{{ __('common.cancel') }}</button>
            <button type="submit" class="save-btn" id="modalSubmitBtn">{{ $editingAnnouncement ? __('common.save_changes') : __('admin.announcements.post_announcement') }}</button>
        </div>
    </form>
</div>

<script>
function toggleAnnouncementMenu(e, btn) {
    e.stopPropagation();
    const dropdown = btn.nextElementSibling;
    document.querySelectorAll('.announcement-dropdown.show').forEach(el => {
        if (el !== dropdown) el.classList.remove('show');
    });
    dropdown.classList.toggle('show');
}
document.addEventListener('click', function () {
    document.querySelectorAll('.announcement-dropdown.show').forEach(el => el.classList.remove('show'));
});

function openCreateAnnouncementModal() {
    document.getElementById('modalTitleHeading').textContent = @json(__('admin.announcements.new_announcement'));
    document.getElementById('announcementForm').action = @json(route('admin.announcements.store'));
    document.getElementById('announcementForm').querySelector('input[name="_method"]')?.remove();
    document.getElementById('modalEditingId').value = '';
    document.getElementById('modalSubmitBtn').textContent = @json(__('admin.announcements.post_announcement'));
    document.getElementById('modalTitleInput').value = '';
    document.getElementById('modalBodyInput').value = '';
    document.getElementById('modalAudienceSelect').value = 'everyone';
    document.getElementById('modalClassSelect').value = '';
    document.getElementById('modalPrioritySelect').value = 'normal';
    document.getElementById('newAnnouncementModal').style.display = 'flex';
}

function openEditAnnouncementModal(btn) {
    const card = btn.closest('.announcement-card');
    const form = document.getElementById('announcementForm');

    document.getElementById('modalTitleHeading').textContent = @json(__('admin.announcements.edit_announcement'));
    form.action = card.dataset.updateUrl;
    if (!form.querySelector('input[name="_method"]')) {
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.prepend(methodField);
    }
    document.getElementById('modalEditingId').value = card.dataset.id;
    document.getElementById('modalSubmitBtn').textContent = @json(__('common.save_changes'));
    document.getElementById('modalTitleInput').value = card.dataset.title;
    document.getElementById('modalBodyInput').value = card.dataset.body;
    document.getElementById('modalAudienceSelect').value = card.dataset.audience;
    document.getElementById('modalClassSelect').value = card.dataset.classId || '';
    document.getElementById('modalPrioritySelect').value = card.dataset.priority;
    document.getElementById('newAnnouncementModal').style.display = 'flex';

    document.querySelectorAll('.announcement-dropdown.show').forEach(el => el.classList.remove('show'));
}
</script>
@endsection
