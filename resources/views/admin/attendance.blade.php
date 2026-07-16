@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Attendance Overview</h1>
        <p>Monitor and manage daily attendance across all classes.</p>
    </div>
    <div class="header-group">
        <label>SELECT CLASS</label>
        <select class="filter-select">
            <option>Grade 12 - A</option>
            <option>Grade 12 - B</option>
            <option>Grade 11 - A</option>
            <option>Grade 11 - B</option>
        </select>
    </div>
</x-page-header>

@php
$students = [
    (object)['name' => 'Serey Sokha', 'id' => 'ST-2023-0482', 'status' => 'present'],
    (object)['name' => 'Visal Rattanak', 'id' => 'ST-2023-1109', 'status' => 'present'],
    (object)['name' => 'Vannak Chantrea', 'id' => 'ST-2023-0021', 'status' => 'late'],
    (object)['name' => 'Dara Phirun', 'id' => 'ST-2022-0941', 'status' => 'absent'],
    (object)['name' => 'Kalyan Bopha', 'id' => 'ST-2023-0112', 'status' => 'present'],
];
$presentCount = collect($students)->where('status', 'present')->count();
$lateCount = collect($students)->where('status', 'late')->count();
$absentCount = collect($students)->where('status', 'absent')->count();
@endphp

<div class="session-card">
    <div>
        <span class="session-label">TODAY'S SESSION</span>
        <h1>Grade 12 - A</h1>
        <div class="session-info">
            <span><i class="fa-regular fa-calendar"></i> {{ date('F j, Y') }}</span>
            <span><i class="fa-regular fa-clock"></i> Period 1 · 7:10 - 8:00 AM</span>
        </div>
    </div>
    <button type="button" class="present-btn"><i class="fa-solid fa-check"></i> Mark All Present</button>
</div>

<div class="attendance-card">
    <div class="attendance-header">
        <span class="student-column">Student</span>
        <span class="status-column">Status</span>
    </div>

    @foreach($students as $student)
        <div class="student-row">
            <div class="student-info">
                <div class="avatar-circle">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                <div>
                    <h4>{{ $student->name }}</h4>
                    <p>{{ $student->id }}</p>
                </div>
            </div>
            <div class="attendance-status">
                <button type="button" class="status-btn {{ $student->status === 'present' ? 'active' : '' }}">Present</button>
                <button type="button" class="status-btn status-late {{ $student->status === 'late' ? 'active' : '' }}">Late</button>
                <button type="button" class="status-btn status-absent {{ $student->status === 'absent' ? 'active' : '' }}">Absent</button>
            </div>
        </div>
    @endforeach

    <div class="attendance-footer">
        <div class="attendance-summary">
            <span class="summary present">{{ $presentCount }} Present</span>
            <span class="summary late">{{ $lateCount }} Late</span>
            <span class="summary absent">{{ $absentCount }} Absent</span>
        </div>
        <button type="button" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>
    </div>
</div>
@endsection