@extends('layouts.teacher')

@section('content')

<div class="gradebook-page">

    <div class="gradebook-header">

        <div class="header-left">

            <h1>Gradebook</h1>

            <p>
                Manage and evaluate academic performance for
                <span>{{ $exam->class->name ?? 'Class' }}</span>
            </p>

        </div>

        <div class="header-right">

            <select>
                <option>Grade 12 - A</option>
                <option>Grade 11 - A</option>
                <option>Grade 10 - A</option>
            </select>

            <select>
                <option>{{ $exam->subject->name }}</option>
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

@foreach($students as $student)

@php
    $score = $results[$student->id]->score ?? 0;

    if ($score >= 90) {
        $grade = 'A';
    } elseif ($score >= 80) {
        $grade = 'B';
    } elseif ($score >= 70) {
        $grade = 'C';
    } elseif ($score >= 60) {
        $grade = 'D';
    } else {
        $grade = 'F';
    }
@endphp

<tr>

    <td>
        <div class="student-info">

            <img src="{{ asset('images/avatar.png') }}" alt="Student">

            <div>
                <h4>{{ $student->name }}</h4>
                <p>ID: {{ $student->student_id }}</p>
            </div>

        </div>
    </td>

    <td>
        <span class="subject-badge">
            {{ $exam->subject->name }}
        </span>
    </td>

    <td>
        <input
            type="number"
            class="score-input"
            value="{{ $score }}">
    </td>

    <td>
        <span class="grade-circle">
            {{ $grade }}
        </span>
    </td>

</tr>

@endforeach

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