@extends('layouts.admin')

@section('content')
<div class="page-title">
    <h1>Teacher Management</h1>
    <p>All registered faculty members for the current semester.</p>
</div>

@if(session('success'))
    <div class="filter-card" style="color:#1a7f37;margin-bottom:8px;">{{ session('success') }}</div>
@endif

<div class="data-card-header" style="background:#fff;border-radius:16px 16px 0 0;border:1px solid #e5e9f2;border-bottom:none;padding:20px 24px;">
    <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;justify-content:space-between;">
        <div class="search-box" style="width:320px;">
            <input type="text" id="teacherSearch" placeholder="e.g. Sophea Rath" onkeyup="liveSearch('teacherSearch','teacherTable')">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div style="display:flex;gap:15px;align-items:center;">
            <a href="{{ route('admin.teachers.create') }}" class="add-btn">
                <i class="fa-solid fa-user-plus"></i> Add Teacher
            </a>
        </div>
    </div>
</div>

<div class="data-card" style="border-radius:0 0 16px 16px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Subject Specialty</th>
                <th>Assigned Classes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="teacherTable">
            @forelse($teachers as $teacher)
                <tr>
                    <td>
                        <strong>{{ $teacher->user->name }}</strong><br>
                        <span style="color:#9ca3af;font-size:13px;">{{ $teacher->user->email }}</span>
                    </td>
                    <td>
                        @if($teacher->subject_specialty)
                            <span class="badge badge-subject">{{ $teacher->subject_specialty }}</span>
                        @else
                            <span style="color:#9ca3af;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($teacher->classes->isNotEmpty())
                            {{ $teacher->classes->pluck('name')->join(', ') }}
                        @else
                            <span style="color:#9ca3af;">None assigned</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" style="display:inline;margin-left:12px;" onsubmit="return confirm('Delete this teacher?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#8a94a6;">No teachers yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px;">{{ $teachers->links() }}</div>
</div>

<script>
function liveSearch(inputId, tableId) {
    var filter = document.getElementById(inputId).value.toLowerCase();
    var rows = document.getElementById(tableId).getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? '' : 'none';
    }
}
</script>
@endsection