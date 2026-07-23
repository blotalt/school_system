@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Class Management</h1>
        <p>Assign homeroom teachers to classes.</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="add-btn">
        <i class="fa-solid fa-plus"></i> Add Class
    </a>
</x-page-header>

@if(session('success'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">{{ session('success') }}</div>
@endif

<div class="data-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Grade</th>
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
                    <td>{{ $class->track ?? '—' }}</td>
                    <td>{{ $class->teacher?->user?->name ?? 'Unassigned' }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td>
                        <a href="{{ route('admin.classes.edit', $class) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this class?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:#8a94a6;">No classes yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection