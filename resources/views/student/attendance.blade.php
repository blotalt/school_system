@extends('layouts.student')

@section('content')

<div class="attendance-page">

    <!-- Welcome Card -->

    <div class="welcome-card">

        <div class="welcome-left">

            <div class="student-photo">

                <img src="{{ asset('images/avatar.png') }}" alt="Student">

            </div>

            <div>

                <h1>Hello, Bruno Mars</h1>

                <div class="student-badges">

                    <span class="grade-badge">
                        Grade 12 - A
                    </span>

                    <span class="track-badge">
                        Science Track
                    </span>

                </div>

            </div>

        </div>

        <div class="welcome-right">

            <span></span>

            <h2></h2>

        </div>

    </div>

        <!-- Attendance Report -->

    <div class="attendance-card">

        <div class="attendance-header">

            <h2>Attendance Report</h2>

        </div>

        <!-- Filter -->

        <div class="attendance-filter">

            <div class="filter-group">

                <label>Subject</label>

                <select>

                    <option>Khmer Literature</option>

                    <option>Mathematics</option>

                    <option>Physics</option>

                    <option>Chemistry</option>

                    <option>English</option>

                </select>

            </div>

            <button class="filter-btn">

                <i class="fa-solid fa-filter"></i>

                Filter

            </button>

        </div>

    </div>

</div>


<!-- Attendance Table -->

<table class="attendance-table">

    <thead>

        <tr>

            <th>SCHEDULE</th>

            <th>COMPENSATION DATE</th>

            <th>ATTENDANCE</th>

        </tr>

    </thead>

    <tbody>


        <tr>

    <td>Wed, 01 April 2026 (16:00 - 16:50)</td>

    <td>-</td>

    <td class="present">Present</td>

</tr>

<tr>

    <td>Fri, 10 April 2026 (11:00 - 11:50)</td>

    <td>-</td>

    <td class="present">Present</td>

</tr>

<tr>

    <td>Wed, 22 April 2026 (16:00 - 16:50)</td>

    <td>-</td>

    <td class="present">Present</td>

</tr>

<tr>

    <td>Fri, 24 April 2026 (11:00 - 11:50)</td>

    <td>-</td>

    <td class="present">Present</td>

</tr>

<tr>

    <td>Wed, 29 April 2026 (16:00 - 16:50)</td>

    <td>-</td>

    <td class="present">Present</td>

</tr>

<tr>

    <td>Fri, 12 June 2026 (10:00 - 10:50)</td>

    <td>-</td>

    <td class="late">Tardy</td>

</tr>

</tbody>

</table>


<!-- Attendance Footer -->

<div class="attendance-footer">

    <span>
       
    </span>

    <div class="attendance-pagination">

        <button>
            
        </button>

        <button>
          
        </button>

    </div>

</div>
@endsection
