@extends('layouts.teacher')

@section('content')

<div class="gradebook-page">

    <div class="gradebook-header">

        <div class="header-left">

            <h1>Gradebook</h1>

            <p>
                Manage and evaluate academic performance for
                <span>Grade 12 - A</span>
            </p>

        </div>

        <div class="header-right">

            <select>
                <option>Grade 12 - A</option>
                <option>Grade 11 - A</option>
                <option>Grade 10 - A</option>
            </select>

            <select>
                <option>Mathematics</option>
                <option>Physics</option>
                <option>Chemistry</option>
                <option>English</option>
            </select>

            <select>
                <option>Monthly Score</option>
                <option>Semester Score</option>
                <option>Homework Score</option>
            </select>

        </div>

    </div>

</div>


<!-- Gradebook Table -->

<div class="gradebook-card">

    <table class="gradebook-table">

        <thead>

            <tr>

                <th>Student Name</th>

                <th>Subject</th>

                <th>Score (0-100)</th>

                <th>Grade</th>

                

            </tr>

        </thead>

        <tbody>

            <!-- Student rows go here -->
<!-- Student 1 -->

<tr>

    <td>
        <div class="student-info">

            <img src="{{ asset('images/student1.jpg') }}" alt="Student">

            <div>
                <h4>Sophal Kim</h4>
                <p>ID: 20230045</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="88">
    </td>

    <td>
        <span class="grade-circle grade-a">A</span>
    </td>

    

</tr>

<!-- Student 2 -->

<tr>

    <td>
        <div class="student-info">

            <img src="{{ asset('images/student2.jpg') }}" alt="Student">

            <div>
                <h4>Bopha Chen</h4>
                <p>ID: 20230046</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="76">
    </td>

    <td>
        <span class="grade-circle grade-b">B</span>
    </td>

    

</tr>

<!-- Student 3 -->

<tr>

    <td>
        <div class="student-info">

            <img src="{{ asset('images/student3.jpg') }}" alt="Student">

            <div>
                <h4>Piseth Vong</h4>
                <p>ID: 20230047</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="62">
    </td>

    <td>
        <span class="grade-circle grade-c">C</span>
    </td>

    

</tr>

<!-- Student 4 -->

<tr>

    <td>
        <div class="student-info">

            <img src="{{ asset('images/student4.jpg') }}" alt="Student">

            <div>
                <h4>Channary Meas</h4>
                <p>ID: 20230048</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="45">
    </td>

    <td>
        <span class="grade-circle grade-d">D</span>
    </td>

    

</tr>

<!-- Student 5 -->

<tr>

    <td>
        <div class="student-info">

            <img src="{{ asset('images/student5.jpg') }}" alt="Student">

            <div>
                <h4>Rithy Som</h4>
                <p>ID: 20230049</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="32">
    </td>

    <td>
        <span class="grade-circle grade-f">F</span>
    </td>

    

</tr>

        </tbody>

    </table>

</div>

<div class="gradebook-footer">

    <div class="footer-text">
        Showing 1-5 of 32 students in Grade 12 - A
    </div>

    <div class="footer-buttons">

        <button class="discard-btn">
            Discard Changes
        </button>

        <button class="save-btn">
            Save All Changes
        </button>

    </div>

</div>




@endsection