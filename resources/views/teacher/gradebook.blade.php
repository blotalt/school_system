@extends('layouts.teacher')

@section('content')

<div class="gradebook-page">

    <div class="gradebook-header">

        <div class="header-left">

            <h1>Gradebook</h1>

            <p>
    Manage and evaluate academic performance for
    <span>Grade 10 - A</span>
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
                <option>Exam</option>
                <option>Homework</option>
            </select>

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

<tbody>

<tr>

    <td>
        <div class="student-info">
            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>Kalyan Bopha</h4>
                <p>ID: 2023XXXX</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="95">
    </td>

    <td>
        <span class="grade-circle grade-a">A</span>
    </td>

</tr>

<tr>

    <td>
        <div class="student-info">
            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>Dara Phirun</h4>
                <p>ID: 2023XXXX</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="86">
    </td>

    <td>
        <span class="grade-circle grade-b">B</span>
    </td>

</tr>

<tr>

    <td>
        <div class="student-info">
            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>Vannak Chantrea</h4>
                <p>ID: 2023XXXX</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="78">
    </td>

    <td>
        <span class="grade-circle grade-c">C</span>
    </td>

</tr>

<tr>

    <td>
        <div class="student-info">
            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>Visal Rattanak</h4>
                <p>ID: 2023XXXX</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="67">
    </td>

    <td>
        <span class="grade-circle grade-d">D</span>
    </td>

</tr>

<tr>

    <td>
        <div class="student-info">
            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>Serey Sokha</h4>
                <p>ID: 2023XXXX</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="52">
    </td>

    <td>
        <span class="grade-circle grade-f">F</span>
    </td>

</tr>

<tr>

    <td>
        <div class="student-info">
            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>Bruno Mars</h4>
                <p>ID: 2023XXXX</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">Mathematics</span>
    </td>

    <td>
        <input type="number" class="score-input" value="91">
    </td>

    <td>
        <span class="grade-circle grade-a">A</span>
    </td>

</tr>

</tbody>

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

</div>


@endsection