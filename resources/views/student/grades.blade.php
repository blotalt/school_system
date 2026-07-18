@extends('layouts.student')

@section('content')

<div class="grade-dashboard">

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

        <!-- Summary Cards -->

    <div class="summary-cards">

        <!-- Attendance -->

        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>

                <span>+2% from last month</span>

            </div>

            <h5>ATTENDANCE RATE</h5>

            <h2>98%</h2>

        </div>

        <!-- Grade -->

        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-icon">
                    <i class="fa-solid fa-book"></i>
                </div>

                <span>Academic Year 2025-2026</span>

            </div>

            <h5>GRADE / REPORT CARD</h5>

            <h2>A</h2>

        </div>

        <!-- Average -->

        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-icon">
                    <i class="fa-regular fa-star"></i>
                </div>

                <span>Top 5% in Class</span>

            </div>

            <h5>AVERAGE SCORE</h5>

            <h2>88.5<small>/100</small></h2>

        </div>

    </div>

</div>


<!-- Recent Academic Performance -->

<div class="performance-card">

    <div class="performance-header">

        <h2>Recent Academic Performance</h2>

        <span>Last updated: May 15, 2024</span>

    </div>

    <table class="performance-table">

        <thead>

            <tr>

                <th>SUBJECT</th>

                <th>WEIGHT</th>

                <th>SCORE (%)</th>

                <th>GRADE</th>

            </tr>

        </thead>

        <tbody>


            <tr>

    <td>

        <div class="subject-cell">

            <div class="subject-icon">

                <i class="fa-solid fa-book-open"></i>

            </div>

            <div>

                <h4>Khmer Literature</h4>

                <p>Advanced Composition</p>

            </div>

        </div>

    </td>

    <td>4.0</td>

    <td>

        <div class="progress-box">

            <div class="progress-fill" style="width:92%;"></div>

        </div>

        <span>92.0</span>

    </td>

    <td>

        <span class="grade green">A</span>

    </td>

</tr>

<tr>

    <td>

        <div class="subject-cell">

            <div class="subject-icon">

                <i class="fa-solid fa-square-root-variable"></i>

            </div>

            <div>

                <h4>Mathematics</h4>

                <p>Calculus & Trigonometry</p>

            </div>

        </div>

    </td>

    <td>5.0</td>

    <td>

        <div class="progress-box">

            <div class="progress-fill" style="width:88%;"></div>

        </div>

        <span>88.5</span>

    </td>

    <td>

        <span class="grade blue">B</span>

    </td>

</tr>

<tr>

    <td>

        <div class="subject-cell">

            <div class="subject-icon">

                <i class="fa-solid fa-flask"></i>

            </div>

            <div>

                <h4>Physics</h4>

                <p>Quantum Mechanics Basics</p>

            </div>

        </div>

    </td>

    <td>4.0</td>

    <td>

        <div class="progress-box">

            <div class="progress-fill" style="width:85%;"></div>

        </div>

        <span>85.0</span>

    </td>

    <td>

        <span class="grade blue">B</span>

    </td>

</tr>

<tr>

    <td>

        <div class="subject-cell">

            <div class="subject-icon">

                <i class="fa-solid fa-vial"></i>

            </div>

            <div>

                <h4>Chemistry</h4>

                <p>Organic Chemistry</p>

            </div>

        </div>

    </td>

    <td>4.0</td>

    <td>

        <div class="progress-box">

            <div class="progress-fill" style="width:74%;"></div>

        </div>

        <span>74.2</span>

    </td>

    <td>

        <span class="grade orange">C</span>

    </td>

</tr>

<tr>

    <td>

        <div class="subject-cell">

            <div class="subject-icon">

                <i class="fa-solid fa-globe"></i>

            </div>

            <div>

                <h4>English</h4>

                <p>IELTS Preparation Track</p>

            </div>

        </div>

    </td>

    <td>3.0</td>

    <td>

        <div class="progress-box">

            <div class="progress-fill" style="width:96%;"></div>

        </div>

        <span>95.8</span>

    </td>

    <td>

        <span class="grade green">A</span>

    </td>

</tr>

</tbody>

</table>

</div>





@endsection
