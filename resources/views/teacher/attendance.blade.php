@extends('layouts.teacher')

@section('content')


<form method="POST" action="{{ route('teacher.attendance.store', $class) }}">
    @csrf
<div class="attendance-page">

    <!-- Ongoing Session -->
    <div class="session-card">

        <div class="session-left">

            <span class="session-label">
                <i class="fa-solid fa-flask"></i>
                ONGOING SESSION
            </span>

            <h1>{{ $class->grade }} - {{ $class->subject->name }}</h1>

            <div class="session-info">

                <span>
                    <i class="fa-regular fa-clock"></i>
                    10:00 AM - 11:30 AM
                </span>

                <span>
                    <i class="fa-solid fa-location-dot"></i>
                    Lab 4
                </span>

            </div>

        </div>

        <button class="present-btn">
            <i class="fa-solid fa-check-double"></i>
            Mark All Present
        </button>

    </div>


    <!-- Attendance Table -->

    <div class="attendance-card">

        <div class="attendance-header">

            <div class="student-column">
                STUDENT NAME & ID
            </div>

            <div class="status-column">
                ATTENDANCE STATUS
            </div>

        </div>

   @foreach($students as $student)

@php
    $status = $records[$student->id]->status ?? 'present';
@endphp

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>{{ $student->name }}</h4>
            <p>ID: {{ $student->student_id }}</p>
        </div>

    </div>

    <div class="attendance-status">

        <button type="button" class="status-btn present {{ $status == 'present' ? 'active' : '' }}" >Present</button>
        <button type="button" class="status-btn late {{ $status == 'late' ? 'active' : '' }}"> Late </button>
        <button type="button" class="status-btn absent {{ $status == 'absent' ? 'active' : '' }}"> Absent </button>
        <input type="hidden" name="attendance[{{ $student->id }}]" value="{{ $status }}" class="attendance-input">

    </div>

</div>

@endforeach

</div>
<div class="attendance-footer">
    <div class="attendance-summary">
        <span>
    <strong>Total Students:</strong>
    {{ $students->count() }}
</span>

        <span class="summary present">Present: 10</span>
        <span class="summary late"> Late: 1</span>
        <span class="summary absent">Absent: 1</span>
    </div>
    <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>

</div>
</div>
</div>
</form>

@endsection