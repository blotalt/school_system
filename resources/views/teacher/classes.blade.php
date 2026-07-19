@extends('layouts.teacher')

@section('content')

<x-page-header>
    <div>
        <h1>My Classes</h1>
        <p>Classes where you are the homeroom teacher.</p>
    </div>
</x-page-header>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Grade</th>
                <th>Track</th>
                <th>Students</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->grade_level ?? '—' }}</td>
                    <td>{{ $class->track ?? 'General' }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td>
                        <a href="{{ route('teacher.attendance.show', $class) }}" class="add-btn">
                            <i class="fa-solid fa-user-check"></i> Attendance
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#8a94a6;">You are not the homeroom teacher for any class yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
