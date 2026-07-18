@extends('layouts.admin')

@section('content')
<x-page-header>
    <div>
        <h1>Teacher Management</h1>
        <p>Managing {{ $teachers->total() }} teachers for the current semester.</p>
    </div>
</x-page-header>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;">
        <div class="search-box" style="width:320px;">
            <input type="text" placeholder="e.g. Sophea Rath">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div style="display:flex;gap:15px;align-items:center;">
            <a href="{{ route('admin.teachers.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> Add
            </a>
        </div>
    </div>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Teacher Name</th>
                <th>Subject</th>
                <th>Assigned Classes</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
                <tr>
                    <td>
                        <strong>{{ $teacher->user->name }}</strong><br>
                        <span style="color:#9ca3af;font-size:13px;">TCH-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td>
                        @forelse($teacher->subjects as $subject)
                            <span class="badge badge-subject">{{ $subject->name }}</span>
                        @empty
                            <span style="color:#9ca3af;">&mdash;</span>
                        @endforelse
                    </td>
                    <td>{{ $teacher->classes->pluck('name')->implode(', ') ?: 'N/A' }}</td>
                    <td>{{ $teacher->user->email }}</td>
                    <td>
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this teacher?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete" style="background:none;border:none;cursor:pointer;color:#9ca3af;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#9ca3af;padding:24px;">No teachers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $teachers->links() }}
</div>
@endsection
