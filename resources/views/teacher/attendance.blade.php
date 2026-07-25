@extends('layouts.teacher')

@section('content')

@php
    $viewingDate = \Illuminate\Support\Carbon::parse($date);
    $isToday = $viewingDate->isToday();
@endphp

<div class="attendance-page">
    <div class="session-card">
        <div class="session-left">
            <span class="session-label">
                <i class="fa-solid fa-flask"></i>
                {{ $isToday ? __('teacher.attendance.todays_session') : __('teacher.attendance.session') }}
            </span>
            <h1>{{ $class->displayName() }}</h1>
            <div class="session-info">
                <span><i class="fa-regular fa-calendar"></i> {{ $viewingDate->format('F j, Y') }}</span>
                <span><i class="fa-solid fa-user-graduate"></i> {{ __('teacher.attendance.students_count', ['count' => $students->count()]) }}</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end;">
            <form method="GET" action="{{ route('teacher.attendance.show', $class) }}" style="display:flex;gap:8px;align-items:center;">
                <a href="{{ route('teacher.attendance.show', ['class' => $class, 'date' => $viewingDate->copy()->subDay()->toDateString()]) }}" class="icon-only-btn" title="{{ __('teacher.attendance.previous_day') }}" style="display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <input type="date" name="date" value="{{ $viewingDate->toDateString() }}" onchange="this.form.submit()" style="height:44px;border:1px solid #e5e9f2;border-radius:10px;padding:0 12px;">
                <a href="{{ route('teacher.attendance.show', ['class' => $class, 'date' => $viewingDate->copy()->addDay()->toDateString()]) }}" class="icon-only-btn" title="{{ __('teacher.attendance.next_day') }}" style="display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </form>
            @if(!$isToday)
                <a href="{{ route('teacher.attendance.show', $class) }}" style="font-size:13px;color:#0b3f86;">{{ __('teacher.attendance.jump_to_today') }}</a>
            @endif
            <div style="display:flex;gap:10px;">
                <a href="{{ route('teacher.attendance.export', ['class' => $class, 'date' => $date]) }}" class="add-btn">
                    <i class="fa-solid fa-file-excel"></i> {{ __('teacher.attendance.export_excel') }}
                </a>
                <a href="{{ route('teacher.attendance.export.pdf', ['class' => $class, 'date' => $date]) }}" class="add-btn" style="background:#dc2626;">
                    <i class="fa-solid fa-file-pdf"></i> {{ __('teacher.attendance.export_pdf') }}
                </a>
            </div>
            <button type="button" id="markAllPresent" class="present-btn">
                <i class="fa-solid fa-check-double"></i> {{ __('teacher.attendance.mark_all_present') }}
            </button>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('teacher.attendance.store', $class) }}">
    @csrf
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="attendance-card">
        <div class="attendance-header">
            <div class="student-column">{{ __('teacher.attendance.student_name_id_column') }}</div>
            <div class="status-column">{{ __('teacher.attendance.status_column') }}</div>
        </div>

        @forelse($students as $student)
            @php $status = $records->get($student->id)?->status; @endphp
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle" style="width:40px;height:40px;">{{ strtoupper(substr($student->user->name, 0, 2)) }}</div>
<div>
    <h4>{{ $student->user->displayName() }}</h4>
    @if($student->user->khmer_name)
        <span style="font-size:12px;color:#9ca3af;">
            {{ app()->getLocale() === 'km' ? $student->user->name : $student->user->khmer_name }}
        </span>
    @endif
    <p>{{ $student->roll_no }}</p>
</div>
                </div>
                <div class="teacher-attendance-status" data-student="{{ $student->id }}">
                    <input type="hidden" name="attendance[{{ $student->id }}]" class="teacher-status-input" value="{{ $status }}">
                    <button type="button" class="teacher-status-btn {{ $status === 'present' ? 'active' : '' }}" data-status="present" onclick="setTeacherStatus({{ $student->id }}, 'present', this)">{{ __('teacher.attendance.present') }}</button>
                    <button type="button" class="teacher-status-btn {{ $status === 'late' ? 'active' : '' }}" data-status="late" onclick="setTeacherStatus({{ $student->id }}, 'late', this)">{{ __('teacher.attendance.late') }}</button>
                    <button type="button" class="teacher-status-btn {{ $status === 'absent' ? 'active' : '' }}" data-status="absent" onclick="setTeacherStatus({{ $student->id }}, 'absent', this)">{{ __('teacher.attendance.absent') }}</button>
                </div>
            </div>
        @empty
            <div class="student-row"><p style="color:#8a94a6;">{{ __('teacher.attendance.no_students_in_class') }}</p></div>
        @endforelse
    </div>

    <div class="attendance-footer">
        <div class="attendance-summary">
            <span><strong>{{ __('teacher.attendance.total_students') }}</strong> {{ $students->count() }}</span>
            <span class="summary present" id="presentSummary">{{ $records->where('status', 'present')->count() }} {{ __('teacher.attendance.present') }}</span>
            <span class="summary late" id="lateSummary">{{ $records->where('status', 'late')->count() }} {{ __('teacher.attendance.late') }}</span>
            <span class="summary absent" id="absentSummary">{{ $records->where('status', 'absent')->count() }} {{ __('teacher.attendance.absent') }}</span>
        </div>
        <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> {{ __('teacher.attendance.save_attendance') }}</button>
    </div>
</form>

<script>
const TEACHER_ATTENDANCE_LABELS = {
    present: @json(__('teacher.attendance.present')),
    late: @json(__('teacher.attendance.late')),
    absent: @json(__('teacher.attendance.absent')),
};

function setTeacherStatus(studentId, status, btn) {
    const group = document.querySelector(`.teacher-attendance-status[data-student="${studentId}"]`);
    group.querySelector('.teacher-status-input').value = status;
    group.querySelectorAll('.teacher-status-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    updateTeacherSummary();
}

document.getElementById('markAllPresent').addEventListener('click', function () {
    document.querySelectorAll('.teacher-attendance-status').forEach(group => {
        const studentId = group.dataset.student;
        const presentBtn = group.querySelector('[data-status="present"]');
        setTeacherStatus(studentId, 'present', presentBtn);
    });
});

function updateTeacherSummary() {
    const values = Array.from(document.querySelectorAll('.teacher-status-input')).map(i => i.value);
    document.getElementById('presentSummary').textContent = values.filter(v => v === 'present').length + ' ' + TEACHER_ATTENDANCE_LABELS.present;
    document.getElementById('lateSummary').textContent = values.filter(v => v === 'late').length + ' ' + TEACHER_ATTENDANCE_LABELS.late;
    document.getElementById('absentSummary').textContent = values.filter(v => v === 'absent').length + ' ' + TEACHER_ATTENDANCE_LABELS.absent;
}
</script>

@endsection
