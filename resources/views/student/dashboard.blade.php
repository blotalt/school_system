@extends('layouts.student')

@section('content')

<div class="student-dashboard">

    <!-- Welcome Card -->

    <div class="welcome-card">

        <div class="welcome-left">

            <div class="student-photo">

                <img src="{{ asset('images/avatar.png') }}" alt="Student">

            </div>

            <div>

                @if($student)
                    <h1>Hello, {{ $student->user->name }}</h1>
                @else
                    <h1>Hello, Student</h1>
                @endif

                <div class="student-badge">

                    <span class="grade-badge">
                        {{ $class?->name ?? 'No Class' }}
                    </span>

                    <span class="track-badge">
                        {{ $class?->track ?? 'N/A' }}
                    </span>

                </div>

            </div>

        </div>

        <div class="welcome-right">

            <span>CURRENT DATE</span>

            <h2>{{ now()->format('F d, Y') }}</h2>

        </div>

    </div>

</div>


<!-- Weekly Schedule -->

<div class="student-timetable">

    <table class="schedule-table">

        <thead>

            <tr>

                <th>
                    <i class="fa-regular fa-clock"></i>
                </th>

                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>

            </tr>

        </thead>

        <tbody>

            <!-- Period 1 -->

            <tr>

                <td class="time-column">
                    07:00<br>07:50
                </td>

                <td>
                    <div class="lesson green">
                        <h4>Mathematics</h4>
                        <p>Room 302</p>
                        <span>SM</span>
                    </div>
                </td>

                <td></td>

                <td>
                    <div class="lesson orange">
                        <h4>Khmer Lit</h4>
                        <p>Library Hall</p>
                        <span>CR</span>
                    </div>
                </td>

                <td></td>

                <td>
                    <div class="lesson blue">
                        <h4>Physics</h4>
                        <p>Lab B</p>
                        <span>NT</span>
                    </div>
                </td>

            </tr>

            <!-- Period 2 -->

            <tr>

                <td class="time-column">
                    08:00<br>08:50
                </td>

                <td>
                    <div class="lesson blue">
                        <h4>Chemistry</h4>
                        <p>Lab A</p>
                        <span>PK</span>
                    </div>
                </td>

                <td>
                    <div class="lesson green">
                        <h4>Mathematics</h4>
                        <p>Room 302</p>
                        <span>SM</span>
                    </div>
                </td>

                <td></td>

                <td>
                    <div class="lesson orange">
                        <h4>History</h4>
                        <p>Room 201</p>
                        <span>LY</span>
                    </div>
                </td>

                <td></td>

            </tr>

            <!-- Break -->

            <tr>

                <td class="time-column">
                    08:50<br>09:10
                </td>

                <td colspan="5" class="break-row">

                    MORNING BREAK & SOCIAL TIME

                </td>

            </tr>

            <!-- Period 3 -->

            <tr>

                <td class="time-column">
                    09:10<br>10:00
                </td>

                <td></td>

                <td>
                    <div class="lesson blue">
                        <h4>English</h4>
                        <p>Room 105</p>
                        <span>JD</span>
                    </div>
                </td>

                <td>
                    <div class="lesson green">
                        <h4>Mathematics</h4>
                        <p>Room 302</p>
                        <span>SM</span>
                    </div>
                </td>

                <td></td>

                <td>
                    <div class="lesson orange">
                        <h4>Geography</h4>
                        <p>Room 204</p>
                        <span>VN</span>
                    </div>
                </td>

            </tr>

        </tbody>

    </table>

</div>


<!-- Today's Schedule -->

<div class="today-card">

    <div class="today-header">

        <h2>Today's Schedule</h2>

        <a href="#">View All</a>

    </div>

    <!-- Item 1 -->

    <div class="today-item">

        <div class="today-left">

            <span class="today-time">
                08:00 - 09:30
            </span>

            <h3>Advanced Physics</h3>

            <p>
                <i class="fa-regular fa-user"></i>
                Dr. Sophal Meas
            </p>

        </div>

        <div class="today-room">
            Room 402
        </div>

    </div>

    <!-- Item 2 -->

    <div class="today-item">

        <div class="today-left">

            <span class="today-time">
                10:00 - 11:30
            </span>

            <h3>Molecular Biology</h3>

            <p>
                <i class="fa-regular fa-user"></i>
                Ms. Chanthea Van
            </p>

        </div>

        <div class="today-room">
            Lab 2A
        </div>

    </div>

    <!-- Item 3 -->

    <div class="today-item">

        <div class="today-left">

            <span class="today-time">
                13:30 - 15:00
            </span>

            <h3>Advanced Mathematics</h3>

            <p>
                <i class="fa-regular fa-user"></i>
                Mr. Dara Sok
            </p>

        </div>

        <div class="today-room">
            Math Hall
        </div>

    </div>

</div>

@endsection
