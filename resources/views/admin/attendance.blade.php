@extends('layouts.admin')

@section('content')
<div class="page-title">
<h1>Attendance Overview</h1>
        <p>View daily attendance across all classes.</p>
</div>

<form method="GET" action="{{ route('admin.attendance.index') }}" style="display:flex;gap:16px;align-items:flex-end;margin-bottom:20px;flex-wrap:wrap;">
    <div class="header-group">
        <label>SELECT CLASS</label>
        <select name="class_id" class="filter-select" onchange="this.form.submit()">
            @foreach($classes as $cls)
                <option value="{{ $cls->id }}" @selected(request('class_id') == $cls->id)>{{ $cls->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="header-group">
        <label>DATE</label>
        <input type="date" name="date" class="filter-select" value="{{ $date }}" onchange="this.form.submit()">
    </div>
</form>

@if($selectedClass)
    <div class="session-card">
        <div>
            <span class="session-label">ATTENDANCE — {{ strtoupper($date) }}</span>
            <h1>{{ $selectedClass->name }}</h1>
            <div class="session-info">
                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
            </div>
        </div>
    </div>

    <div class="attendance-card">
        <div class="attendance-header">
            <span class="student-column">Student</span>
            <span class="status-column">Status</span>
        </div>

        @forelse($students as $student)
            @php $status = $records->get($student->id)?->status ?? null; @endphp
            <div class="student-row">
                <div class="student-info">
                    <div class="avatar-circle">{{ strtoupper(substr($student->user->name, 0, 1)) }}</div>
                    <div>
                        <h4>{{ $student->user->name }}</h4>
                        <p>{{ $student->roll_no }}</p>
                    </div>
                </div>
                <div class="attendance-status">
                    <span class="status-btn {{ $status === 'present' ? 'active' : '' }}">Present</span>
                    <span class="status-btn status-late {{ $status === 'late' ? 'active' : '' }}">Late</span>
                    <span class="status-btn status-absent {{ $status === 'absent' ? 'active' : '' }}">Absent</span>
                    @if(!$status) <span style="color:#9ca3af;font-size:13px;">Not recorded</span> @endif
                </div>
            </div>
        @empty
            <div style="padding:20px;color:#8a94a6;text-align:center;">No students in this class.</div>
        @endforelse

        <div class="attendance-footer">
            <div class="attendance-summary">
                <span class="summary present">{{ $presentCount }} Present</span>
                <span class="summary late">{{ $lateCount }} Late</span>
                <span class="summary absent">{{ $absentCount }} Absent</span>
                <span style="color:#9ca3af;">{{ $students->count() - $presentCount - $lateCount - $absentCount }} Not recorded</span>
            </div>
        </div>
    </div>
@endif
@endsection
