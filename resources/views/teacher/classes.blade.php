@extends('layouts.teacher')

@section('content')
<div class="page-title">
<h1>My Classes</h1>
        <p>Classes assigned to you for the current academic year.</p>
</div>

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Grade Level</th>
                <th>Track</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td><strong>{{ $class->name }}</strong></td>
                    <td>{{ $class->grade_level ?? '—' }}</td>
                    <td>
                        @if($class->track)
                            <span class="badge badge-science">{{ $class->track }}</span>
                        @else
                            <span style="color:#9ca3af;">—</span>
                        @endif
                    </td>
                    <td>{{ $class->students_count }}</td>
                    <td>
                        <a href="{{ route('teacher.attendance.show', $class) }}" title="Attendance" style="margin-right:12px;">
                            <i class="fa-solid fa-user-check"></i> Attendance
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:#8a94a6;">No classes assigned yet. Contact admin.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
