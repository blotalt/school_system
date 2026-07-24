@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>{{ __('admin.attendance.title') }}</h1>
        <p>{{ __('admin.attendance.subtitle') }}</p>
    </div>
    @if($class)
    <form method="GET" action="{{ route('admin.attendance.index') }}" class="header-group">
        <label>{{ __('admin.attendance.select_class') }}</label>
        <select name="class" class="filter-select" onchange="this.form.submit()">
            @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ $class->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </form>
    @endif
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

@if(!$class)
    <div class="data-card" style="padding:40px;text-align:center;color:#9ca3af;">
        {{ __('admin.attendance.no_classes_yet') }}
    </div>
@else

<div class="session-card">
    <div>
        <span class="session-label">{{ __('admin.attendance.todays_session') }}</span>
        <h1>{{ $class->displayName() }}</h1>
        <div class="session-info">
            <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
            <span><i class="fa-solid fa-user-graduate"></i> {{ __('admin.attendance.students_count', ['count' => $students->count()]) }}</span>
        </div>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <a href="{{ route('admin.attendance.export', $class) }}" class="add-btn">
            <i class="fa-solid fa-file-excel"></i> {{ __('admin.attendance.export_excel') }}
        </a>
        <a href="{{ route('admin.attendance.export.pdf', $class) }}" class="add-btn" style="background:#dc2626;">
            <i class="fa-solid fa-file-pdf"></i> {{ __('admin.attendance.export_pdf') }}
        </a>
        <button type="button" class="present-btn" onclick="markAllPresent()"><i class="fa-solid fa-check"></i> {{ __('admin.attendance.mark_all_present') }}</button>
    </div>
</div>

<form method="POST" action="{{ route('admin.attendance.store', $class) }}">
    @csrf
    <div class="attendance-card">
        <div class="attendance-header">
            <span class="student-column">{{ __('admin.attendance.student_column') }}</span>
            <span class="status-column">{{ __('admin.attendance.status_column') }}</span>
        </div>

        @forelse($students as $student)
            @php $status = $marked->get($student->id); @endphp
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle">{{ strtoupper(substr($student->user->displayName(), 0, 1)) }}</div>
                    <div>
                        <h4>{{ $student->user->displayName() }}</h4>
                        <p>{{ $student->roll_no }}</p>
                    </div>
                </div>
                <div class="attendance-status" data-student="{{ $student->id }}">
                    <input type="hidden" name="attendance[{{ $student->id }}]" class="status-input" value="{{ $status }}">
                    <button type="button" class="status-btn {{ $status === 'present' ? 'active' : '' }}" onclick="setStatus({{ $student->id }}, 'present', this)">{{ __('admin.attendance.present') }}</button>
                    <button type="button" class="status-btn status-late {{ $status === 'late' ? 'active' : '' }}" onclick="setStatus({{ $student->id }}, 'late', this)">{{ __('admin.attendance.late') }}</button>
                    <button type="button" class="status-btn status-absent {{ $status === 'absent' ? 'active' : '' }}" onclick="setStatus({{ $student->id }}, 'absent', this)">{{ __('admin.attendance.absent') }}</button>
                </div>
            </div>
        @empty
            <div class="student-row" style="justify-content:center;color:#9ca3af;">{{ __('admin.attendance.no_students_in_class') }}</div>
        @endforelse

        <div class="attendance-footer">
            <div class="attendance-summary">
                <span class="summary present" id="presentSummary">{{ $presentCount }} {{ __('admin.attendance.present') }}</span>
                <span class="summary late" id="lateSummary">{{ $lateCount }} {{ __('admin.attendance.late') }}</span>
                <span class="summary absent" id="absentSummary">{{ $absentCount }} {{ __('admin.attendance.absent') }}</span>
            </div>
            <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> {{ __('admin.attendance.save_attendance') }}</button>
        </div>
    </div>
</form>

<script>
const ATTENDANCE_LABELS = {
    present: @json(__('admin.attendance.present')),
    late: @json(__('admin.attendance.late')),
    absent: @json(__('admin.attendance.absent')),
};

function setStatus(studentId, status, btn) {
    const group = document.querySelector(`.attendance-status[data-student="${studentId}"]`);
    group.querySelector('.status-input').value = status;
    group.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    updateSummary();
}

function markAllPresent() {
    document.querySelectorAll('.attendance-status').forEach(group => {
        const studentId = group.dataset.student;
        const presentBtn = group.querySelector('.status-btn:not(.status-late):not(.status-absent)');
        setStatus(studentId, 'present', presentBtn);
    });
}

function updateSummary() {
    const values = Array.from(document.querySelectorAll('.status-input')).map(i => i.value);
    document.getElementById('presentSummary').textContent = values.filter(v => v === 'present').length + ' ' + ATTENDANCE_LABELS.present;
    document.getElementById('lateSummary').textContent = values.filter(v => v === 'late').length + ' ' + ATTENDANCE_LABELS.late;
    document.getElementById('absentSummary').textContent = values.filter(v => v === 'absent').length + ' ' + ATTENDANCE_LABELS.absent;
}
</script>
@endif
@endsection
