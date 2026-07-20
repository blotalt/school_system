@extends('layouts.admin')

@section('content')
<div class="page-title-bar">
    <div>
        <h1>Class Management</h1>
        <p>All classes for the current academic year.</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="add-btn">
        <i class="fa-solid fa-plus"></i> Add Class
    </a>
</div>

@if(session('success'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Grade Level</th>
                <th>Track</th>
                <th>Homeroom Teacher</th>
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
                    <td>{{ $class->teacher?->user?->name ?? 'Unassigned' }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td>
                        <a href="{{ route('admin.classes.edit', $class) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this class?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:#8a94a6;">No classes yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $classes->links() }}</div>
</div>
@endsection
