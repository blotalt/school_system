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

            <h1>Grade 12A - Mathematics</h1>

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

    </div>

</div>



<!-- Student 1 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student1.jpg') }}" alt="Student">

        <div>

            <h4>Kalyan Bopha</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>

<!-- Student 2 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student2.jpg') }}" alt="Student">

        <div>

            <h4>Dara Phirun</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>

<!-- Student 3 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student3.jpg') }}" alt="Student">

        <div>

            <h4>Vannak Chantrea</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>

<!-- Student 4 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student4.jpg') }}" alt="Student">

        <div>

            <h4>Visal Rattanak</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>

<!-- Student 5 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student5.jpg') }}" alt="Student">

        <div>

            <h4>Serey Sokha</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>

<!-- Student 6 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student6.jpg') }}" alt="Student">

        <div>

            <h4>Bruno Mars</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>

<!-- Student 7 -->

<div class="student-row">

    <div class="student-info">

        <img src="{{ asset('images/student7.jpg') }}" alt="Student">

        <div>

            <h4>Channary Meas</h4>
            <p>ID: 2023XXXX</p>

        </div>

    </div>

    <div class="attendance-status">

        <button class="status-btn present active">Present</button>
        <button class="status-btn">Late</button>
        <button class="status-btn">Absent</button>

    </div>

</div>



<!-- Attendance Footer -->

<div class="attendance-footer">

    <div class="attendance-summary">

        <span><strong>Total Students:</strong> 12</span>

        <span class="summary present">
            Present: 10
        </span>

        <span class="summary late">
            Late: 1
        </span>

        <span class="summary absent">
            Absent: 1
        </span>

    </div>

    <button class="save-attendance-btn">

        <i class="fa-solid fa-floppy-disk"></i>

        Save Attendance

    </button>

</div>

@endsection