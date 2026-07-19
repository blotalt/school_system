@extends('layouts.teacher')

@section('content')



<div class="attendance-page">

    <!-- Ongoing Session -->
    <div class="session-card">

        <div class="session-left">

            <span class="session-label">
                <i class="fa-solid fa-flask"></i>
                ONGOING SESSION
            </span>

            <h1>Grade 10-A - Mathematics</h1>

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

        <button id="markAllPresent" class="present-btn">
            <i class="fa-solid fa-check-double"></i>
            Mark All Present
        </button>

    </div>
</div>

   <div class="header-action">

            <div class="class-select">

                <label>Select Class</label>

                <select>
                    <option>Grade 12 - ALL</option>
                    <option>Grade 11 - A</option>
                    <option>Grade 10 - A</option>
                </select>

            </div>

            

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

   <div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>Kalyan Bopha</h4>
            <p>ID: 2023XXXX</p>
        </div>

    </div>

   <div class="teacher-attendance-status">

    <button
        type="button"
        class="teacher-status-btn active"
        data-status="present">
        Present
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="late">
        Late
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="absent">
        Absent
    </button>

</div>

</div>

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>Dara Phirun</h4>
            <p>ID: 2023XXXX</p>
        </div>

    </div>

    <div class="teacher-attendance-status">

    <button
        type="button"
        class="teacher-status-btn active"
        data-status="present">
        Present
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="late">
        Late
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="absent">
        Absent
    </button>

</div>

</div>

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>Vannak Chantrea</h4>
            <p>ID: 2023XXXX</p>
        </div>

    </div>

    <div class="teacher-attendance-status">

    <button
        type="button"
        class="teacher-status-btn active"
        data-status="present">
        Present
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="late">
        Late
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="absent">
        Absent
    </button>

</div>

</div>

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>Visal Rattanak</h4>
            <p>ID: 2023XXXX</p>
        </div>

    </div>

    <div class="teacher-attendance-status">

    <button
        type="button"
        class="teacher-status-btn active"
        data-status="present">
        Present
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="late">
        Late
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="absent">
        Absent
    </button>

</div>

</div>

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>Serey Sokha</h4>
            <p>ID: 2023XXXX</p>
        </div>

    </div>

    <div class="teacher-attendance-status">

    <button
        type="button"
        class="teacher-status-btn active"
        data-status="present">
        Present
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="late">
        Late
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="absent">
        Absent
    </button>

</div>

</div>

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/avatar.png') }}" alt="Student">

        <div>
            <h4>Bruno Mars</h4>
            <p>ID: 2023XXXX</p>
        </div>

    </div>

    <div class="teacher-attendance-status">

    <button
        type="button"
        class="teacher-status-btn active"
        data-status="present">
        Present
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="late">
        Late
    </button>

    <button
        type="button"
        class="teacher-status-btn"
        data-status="absent">
        Absent
    </button>

</div>

</div>
</div>
<div class="attendance-footer">
    <div class="attendance-summary">
        <span>
    <strong>Total Students:</strong>
    
</span>

        <span class="summary present">Present: 10</span>
        <span class="summary late"> Late: 1</span>
        <span class="summary absent">Absent: 1</span>
    </div>
    <button type="submit" class="save-attendance-btn"><i class="fa-solid fa-floppy-disk"></i> Save Attendance</button>

</div>
</div>
</div>


@endsection