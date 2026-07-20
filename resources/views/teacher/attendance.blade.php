@extends('layouts.teacher')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('teacher.classes.index') }}">Classes</a> &gt;
    <span>Attendance</span>
</div>

<form method="POST" action="{{ route('teacher.attendance.store', $class) }}">
    @csrf

    <input type="hidden" name="date" value="{{ $date }}">

    <div class="session-card">
        <div class="session-left">
            <span class="session-label"><i class="fa-solid fa-user-check"></i> ATTENDANCE</span>
            <h1>{{ $class->name }}</h1>
            <div class="session-info">
                <span><i class="fa-regular fa-calendar"></i>
                    <input type="date" name="date" value="{{ $date }}"
                           style="border:none;background:transparent;font-size:inherit;cursor:pointer;"
                           onchange="this.form.submit()">
                </span>
            </div>
        </div>
        <button type="button" id="markAllPresent" class="present-btn" onclick="markAll('present')">
            <i class="fa-solid fa-check-double"></i> Mark All Present
        </button>
    </div>

    @if(session('success'))
        <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
    @endif

    <div class="attendance-card">
        <div class="attendance-header">
            <div class="student-column">STUDENT NAME & ID</div>
            <div class="status-column">ATTENDANCE STATUS</div>
        </div>

        @forelse($students as $student)
            @php $currentStatus = $records->get($student->id)?->status ?? 'present'; @endphp
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle">{{ strtoupper(substr($student->user->name, 0, 1)) }}</div>
                    <div>
                        <h4>{{ $student->user->name }}</h4>
                        <p>{{ $student->roll_no }}</p>
                    </div>
                </div>
                <div class="teacher-attendance-status" data-student="{{ $student->id }}">
                    <input type="hidden" name="attendance[{{ $student->id }}]" value="{{ $currentStatus }}" class="status-value">
                    <button type="button" class="teacher-status-btn {{ $currentStatus === 'present' ? 'active' : '' }}" data-status="present">Present</button>
                    <button type="button" class="teacher-status-btn {{ $currentStatus === 'late' ? 'active' : '' }}" data-status="late">Late</button>
                    <button type="button" class="teacher-status-btn {{ $currentStatus === 'absent' ? 'active' : '' }}" data-status="absent">Absent</button>
                </div>
            </div>
        @empty
            <div style="padding:20px;color:#8a94a6;text-align:center;">No students in this class.</div>
        @endforelse

        <div class="attendance-footer">
            <div class="attendance-summary">
                <span><strong>Total:</strong> {{ $students->count() }}</span>
            </div>
            <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>
        </div>
    </div>
</form>

<script>
document.querySelectorAll('.teacher-attendance-status').forEach(function(group) {
    group.querySelectorAll('.teacher-status-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            group.querySelectorAll('.teacher-status-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            group.querySelector('.status-value').value = this.dataset.status;
        });
    });
});

function markAll(status) {
    document.querySelectorAll('.teacher-attendance-status').forEach(function(group) {
        group.querySelectorAll('.teacher-status-btn').forEach(b => b.classList.remove('active'));
        group.querySelector('[data-status="' + status + '"]').classList.add('active');
        group.querySelector('.status-value').value = status;
    });
}
</script>
@endsection
