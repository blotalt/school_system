@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Attendance Overview</h1>
        <p>Monitor and manage daily attendance across all classes.</p>
    </div>
    @if($class)
    <form method="GET" action="{{ route('admin.attendance.index') }}" class="header-group">
        <label>SELECT CLASS</label>
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
        No classes exist yet.
    </div>
@else

<div class="session-card">
    <div>
        <span class="session-label">TODAY'S SESSION</span>
        <h1>{{ $class->name }}</h1>
        <div class="session-info">
            <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
            <span><i class="fa-regular fa-user-graduate"></i> {{ $students->count() }} students</span>
        </div>
    </div>
    <button type="button" class="present-btn" onclick="markAllPresent()"><i class="fa-solid fa-check"></i> Mark All Present</button>
</div>

<form method="POST" action="{{ route('admin.attendance.store', $class) }}">
    @csrf
    <div class="attendance-card">
        <div class="attendance-header">
            <span class="student-column">Student</span>
            <span class="status-column">Status</span>
        </div>

        @forelse($students as $student)
            @php $status = $marked->get($student->id); @endphp
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle">{{ strtoupper(substr($student->user->name, 0, 1)) }}</div>
                    <div>
                        <h4>{{ $student->user->name }}</h4>
                        <p>{{ $student->roll_no }}</p>
                    </div>
                </div>
                <div class="attendance-status" data-student="{{ $student->id }}">
                    <input type="hidden" name="attendance[{{ $student->id }}]" class="status-input" value="{{ $status }}">
                    <button type="button" class="status-btn {{ $status === 'present' ? 'active' : '' }}" onclick="setStatus({{ $student->id }}, 'present', this)">Present</button>
                    <button type="button" class="status-btn status-late {{ $status === 'late' ? 'active' : '' }}" onclick="setStatus({{ $student->id }}, 'late', this)">Late</button>
                    <button type="button" class="status-btn status-absent {{ $status === 'absent' ? 'active' : '' }}" onclick="setStatus({{ $student->id }}, 'absent', this)">Absent</button>
                </div>
            </div>
        @empty
            <div class="student-row" style="justify-content:center;color:#9ca3af;">No students in this class.</div>
        @endforelse

        <div class="attendance-footer">
            <div class="attendance-summary">
                <span class="summary present" id="presentSummary">{{ $presentCount }} Present</span>
                <span class="summary late" id="lateSummary">{{ $lateCount }} Late</span>
                <span class="summary absent" id="absentSummary">{{ $absentCount }} Absent</span>
            </div>
            <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>
        </div>
    </div>
</form>

<script>
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
    document.getElementById('presentSummary').textContent = values.filter(v => v === 'present').length + ' Present';
    document.getElementById('lateSummary').textContent = values.filter(v => v === 'late').length + ' Late';
    document.getElementById('absentSummary').textContent = values.filter(v => v === 'absent').length + ' Absent';
}
</script>
@endif
@endsection
