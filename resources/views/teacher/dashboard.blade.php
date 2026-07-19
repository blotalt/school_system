@extends('layouts.teacher')

@section('content')

<div class="timetable-page">

    <!-- Header -->
    <div class="page-header">

        <div>
            <h1>Timetable Builder</h1>
            <p>Configure weekly academic schedules for upper-secondary grades.</p>
        </div>

        <div class="header-action">

            <div class="class-select">

                <label>Select Class</label>

                <select>
                    <option>Grade 12 - ALL</option>
                    <option>Grade 11</option>
                    <option>Grade 10</option>
                </select>

            </div>

            

        </div>

    </div>

</div>

<div class="schedule-wrapper">

    <!-- Left -->
    <div class="timetable-container">

        <table class="timetable">

            <thead>
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td class="time-box">07:00<br>07:50</td>

                    <td>
                        <div class="subject-box">
                            <h4>Mathematics</h4>
                            <p>Room 302</p>
                            <span class="subject-tag">SM</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>Mathematics</h4>
                            <p>Room 302</p>
                            <span class="subject-tag">SM</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>Mathematics</h4>
                            <p>Room 302</p>
                            <span class="subject-tag">SM</span>
                        </div>
                    </td>

                </tr>

                <tr>
                    <td class="time-box">08:00<br>08:50</td>

                    <td>
                        <div class="subject-box">
                            <h4>Physics</h4>
                            <p>Room 305</p>
                            <span class="subject-tag">PH</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>Chemistry</h4>
                            <p>Lab 2A</p>
                            <span class="subject-tag">CH</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>Biology</h4>
                            <p>Room 401</p>
                            <span class="subject-tag">BI</span>
                        </div>
                    </td>

                </tr>

                <tr>
                    <td class="time-box">08:50<br>09:10</td>

                    <td colspan="5" class="break-box">
                        MORNING BREAK & SOCIAL TIME
                    </td>
                </tr>

                <tr>
                    <td class="time-box">09:10<br>10:00</td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>English</h4>
                            <p>Room 205</p>
                            <span class="subject-tag">EN</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>History</h4>
                            <p>Room 210</p>
                            <span class="subject-tag">HI</span>
                        </div>
                    </td>

                    <td></td>

                </tr>

                <tr>
                    <td class="time-box">10:10<br>11:00</td>

                    <td>
                        <div class="subject-box">
                            <h4>Khmer</h4>
                            <p>Room 101</p>
                            <span class="subject-tag">KH</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>Computer</h4>
                            <p>Lab 1</p>
                            <span class="subject-tag">IT</span>
                        </div>
                    </td>

                    <td></td>

                    <td>
                        <div class="subject-box">
                            <h4>Geography</h4>
                            <p>Room 307</p>
                            <span class="subject-tag">GE</span>
                        </div>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <!-- Right -->
</div>








<!-- Today's Schedule -->

<div class="today-card">

    <div class="today-header">

        <h2>Today's Schedule</h2>

        <a href="#">View All</a>

    </div>

    <!-- Schedule Item 1 -->

    <div class="today-item">

        <div class="today-left">

            <span class="time">08:00 - 09:30</span>

            <h3>Mathematics</h3>

            <p>Class 12A</p>

        </div>

        <div class="today-room">

            Room 402

        </div>

    </div>

    <!-- Schedule Item 2 -->

    <div class="today-item">

        <div class="today-left">

            <span class="time">10:00 - 11:30</span>

            <h3>Physics</h3>

            <p>Class 12B</p>

        </div>

        <div class="today-room">

            Lab 2A

        </div>

    </div>

    <!-- Schedule Item 3 -->

    <div class="today-item">

        <div class="today-left">

            <span class="time">13:30 - 15:00</span>

            <h3>Chemistry</h3>

            <p>Class 12C</p>

        </div>

        <div class="today-room">

            Room 305

        </div>

    </div>

</div>


@endsection
