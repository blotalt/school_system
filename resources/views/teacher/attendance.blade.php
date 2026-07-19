@extends('layouts.teacher')

@section('content')

<div class="attendance-page">
    <div class="session-card">
        <div class="session-left">
            <span class="session-label">
                <i class="fa-solid fa-flask"></i>
                TODAY'S SESSION
            </span>
            <h1>{{ $class->name }}</h1>
            <div class="session-info">
                <span><i class="fa-regular fa-calendar"></i> {{ \Illuminate\Support\Carbon::parse($date)->format('F j, Y') }}</span>
                <span><i class="fa-regular fa-user-graduate"></i> {{ $students->count() }} students</span>
            </div>
        </div>
        <button type="button" id="markAllPresent" class="present-btn">
            <i class="fa-solid fa-check-double"></i> Mark All Present
        </button>
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
            <div class="student-column">STUDENT NAME & ID</div>
            <div class="status-column">ATTENDANCE STATUS</div>
        </div>

        @forelse($students as $student)
            @php $status = $records->get($student->id)?->status; @endphp
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle" style="width:40px;height:40px;">{{ strtoupper(substr($student->user->name, 0, 2)) }}</div>
                    <div>
                        <h4>{{ $student->user->name }}</h4>
                        <p>{{ $student->roll_no }}</p>
                    </div>
                </div>
                <div class="teacher-attendance-status" data-student="{{ $student->id }}">
                    <input type="hidden" name="attendance[{{ $student->id }}]" class="teacher-status-input" value="{{ $status }}">
                    <button type="button" class="teacher-status-btn {{ $status === 'present' ? 'active' : '' }}" data-status="present" onclick="setTeacherStatus({{ $student->id }}, 'present', this)">Present</button>
                    <button type="button" class="teacher-status-btn {{ $status === 'late' ? 'active' : '' }}" data-status="late" onclick="setTeacherStatus({{ $student->id }}, 'late', this)">Late</button>
                    <button type="button" class="teacher-status-btn {{ $status === 'absent' ? 'active' : '' }}" data-status="absent" onclick="setTeacherStatus({{ $student->id }}, 'absent', this)">Absent</button>
                </div>
            </div>
        @empty
            <div class="student-row"><p style="color:#8a94a6;">No students in this class.</p></div>
        @endforelse
    </div>

    <div class="attendance-footer">
        <div class="attendance-summary">
            <span><strong>Total Students:</strong> {{ $students->count() }}</span>
            <span class="summary present" id="presentSummary">{{ $records->where('status', 'present')->count() }} Present</span>
            <span class="summary late" id="lateSummary">{{ $records->where('status', 'late')->count() }} Late</span>
            <span class="summary absent" id="absentSummary">{{ $records->where('status', 'absent')->count() }} Absent</span>
        </div>
        <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>
    </div>
</form>

<script>
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
    document.getElementById('presentSummary').textContent = values.filter(v => v === 'present').length + ' Present';
    document.getElementById('lateSummary').textContent = values.filter(v => v === 'late').length + ' Late';
    document.getElementById('absentSummary').textContent = values.filter(v => v === 'absent').length + ' Absent';
}
</script>

@endsection
